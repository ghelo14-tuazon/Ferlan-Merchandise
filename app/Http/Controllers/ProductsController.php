<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\WalkinSale;
use App\Http\Controllers\WalkinSaleController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use PDF;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::get();
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.product.create')->with('categories',$category)->with('brands',$brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        // return $size;
        // return $data;
        $status=Product::create($data);
        if($status){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::get();
        $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$category)->with('items',$items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'brand_id'=>'nullable|exists:brands,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
   
    public function addStock($id, Request $request)
    {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'stock_info' => 'required|string',
        ]);
    
        // Split the input into quantity and size
        $stockInfoParts = explode(',', $request->stock_info);
    
        // Check if both parts are present
        if (count($stockInfoParts) !== 2) {
            // Handle validation error
            return redirect()->route('product.inventory')->with('error', 'Invalid input format');
        }
    
        list($quantity, $size) = array_map('trim', $stockInfoParts);
    
        // Validate quantity (you can add more validation rules if needed)
        $quantity = intval($quantity);
        if ($quantity < 1) {
            // Handle validation error
            return redirect()->route('product.inventory')->with('error', 'Invalid quantity');
        }
    
        // Validate size (you can add more validation rules if needed)
        $allowedSizes = ['Small', 'Medium', 'Large', 'small', 'medium', 'large']; // Adjust according to your sizes
        if (!in_array($size, $allowedSizes)) {
            // Handle validation error
            return redirect()->route('product.inventory')->with('error', 'Invalid size');
        }
    
        // Assuming you have columns stock_small, stock_medium, stock_large in your database
        $sizeColumn = 'stock_' . strtolower($size);
    
        // Use a transaction to ensure data consistency
        DB::transaction(function () use ($product, $quantity, $size, $sizeColumn) {
            // Update the general stock column and the size-specific stock column
            $product->update([
                'stock' => $product->stock + $quantity,
                $sizeColumn => $product->$sizeColumn + $quantity,
                'added_stock_history' => $product->added_stock_history + $quantity, // Update the added_stock_history column
                'stock_added_at' => now(),
            ]);
    
            // Create a new stock history record
            $product->stockHistory()->create([
                'quantity' => $quantity,
                'size' => ucfirst(strtolower($size)), // Convert to lowercase and then capitalize the first letter
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    
        return redirect()->route('product.inventory')->with('success', 'Stock added successfully.');
    }
    
public function StockHistory($id)
{
    $product = Product::findOrFail($id);
    $stockHistory = $product->stockHistory()->latest('created_at')->paginate(3);

    return view('staff.product.stock_history', compact('product', 'stockHistory'));
}
    
public function processSale(Request $request)
{
    $productInfoArray = $request->input('product_info');
    $successMessage = 'Sales successfully processed.';

    // Check if the product info array is null or empty
    if ($productInfoArray === null || empty($productInfoArray)) {
        return redirect()->back()->with('error', 'Invalid product info data');
    }

    $orderNumber = uniqid(); // Generate a unique order number (replace this with your logic)

    $errorFlag = false;
    $productDetails = [];
    $totalOrderPrice = 0;
    $insufficientStock = false; // Initialize the flag for insufficient stock

    foreach ($productInfoArray as $productInfo) {
        // Split product info into product_id, quantity, and size
        $info = explode('@', $productInfo);

        // Check if the expected number of elements is present
        if (count($info) !== 3) {
            $errorFlag = true;
            session()->flash('error', 'Invalid product info format');
            break; // Exit the loop
        }

        list($productId, $quantity, $size) = $info;

        // Find the product by ID
        $product = Product::find($productId);

        // Check if the product exists
        if (!$product) {
            $errorFlag = true;
            session()->flash('error', 'Product not found for ID: ' . $productId);
            break; // Exit the loop
        }

        // Check if the quantity is valid
        if ($quantity <= 0 || $quantity > $product->stock) {
            $errorFlag = true;
            $insufficientStock = true; // Set the flag for insufficient stock
            session()->flash('error', 'Invalid quantity for product: ' . $product->title);
            break; // Exit the loop
        }
        

        // Check if the specified size is valid
        $validSizesForCat15 = ['41', '42', '43'];
        $validSizesForOtherCats = ['small', 'medium', 'large'];
        
        // Assuming $product is an instance of your product model and has a 'cat_id' property
        if ($product->cat_id == 15) {
            // If cat_id is 15, only sizes '41', '42', and '43' are valid
            if (!in_array($size, $validSizesForCat15)) {
                $errorFlag = true;
                session()->flash('error', 'Invalid size specified for product: ' . $product->title);
                break; // Exit the loop
            }
        } else {
            // If cat_id is not 15, only sizes 'small', 'medium', and 'large' are valid
            if (!in_array($size, $validSizesForOtherCats)) {
                $errorFlag = true;
                session()->flash('error', 'Invalid size specified for product: ' . $product->title);
                break; // Exit the loop
            }
        }
        
        
        

        // Check if deducting stock would result in a negative value
        if ($size == '41') {
            $column = 'stock_small';
        } elseif ($size == '42') {
            $column = 'stock_medium';
        } elseif ($size == '43') {
            $column = 'stock_large';
        } else {
            $column = 'stock_' . $size;
        }

        if ($product->$column - $quantity < 0) {
            $errorFlag = true;
            $insufficientStock = true; // Set the flag for insufficient stock
            session()->flash('error', 'Insufficient stock for product: ' . $product->title);
            break; // Exit the loop
        }

        $totalPrice = $product->price * $quantity;
        $totalOrderPrice += $totalPrice;

        // Deduct stock based on size
        $product->$column -= $quantity;

        // Deduct from general stock column
        $product->stock -= $quantity;

        $product->sold_stock += $quantity;
        $product->save();

        // Save the walk-in sale with order number and size
        WalkinSale::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'order_number' => $orderNumber,
            'size' => $size,
        ]);

        // Store product details for the receipt
        $productDetails[] = [
            'title' => $product->title,
            'quantity' => $quantity,
            'total' => $totalPrice,
            'size' => $size,
        ];
    }

    // Check for insufficient stock and display alert if needed
    if ($insufficientStock) {
        return redirect()->back()->with('insufficientStock', true);
    }

    if ($errorFlag) {
        return redirect()->back();
    }

    // Generate PDF receipt with product details and totalOrderPrice
    $pdf = PDF::loadView('receipt', [
        'successMessage' => $successMessage,
        'productDetails' => $productDetails,
        'totalOrderPrice' => $totalOrderPrice,
        'orderNumber' => $orderNumber,
    ]);

    // Save the PDF file with order number
    $pdfFileName = 'receipt_order_' . $orderNumber . '.pdf';
    $pdfPath = storage_path('app/receipts/' . $pdfFileName);
    $pdf->save($pdfPath);

    // Store PDF path, order number, and product details in the session
    session(['pdf_path' => $pdfPath, 'order_number' => $orderNumber, 'product_details' => $productDetails]);

    return redirect()->back()->with('success', $successMessage)->with('showModal', true);
}




public function walkthroughSaleView()
{
    $products = Product::paginate(4); // Adjust the number per page as needed

    return view('staff.walkthrough.walkthrough-sale', compact('products'));
}

public function showWalkinSales()
{
    $walkinSales = WalkinSale::orderBy('id', 'desc')->paginate(10); // Order by id in descending order

    return view('staff.walkthrough.walkin-sales-history', compact('walkinSales'));
}

public function showInventory()
{
    // Assuming you have the 'Product' model
    $products = Product::paginate(5); // Change 10 to the number of items you want per page
    $sizes = Product::distinct()->pluck('size')->toArray();

    return view('staff.product.inventory', ['products' => $products]);
}
public function downloadReceipt()
{
    // Get the PDF path from the session
    $pdfPath = session('pdf_path');

    // Generate a timestamp for the filename
    $timestamp = time();

    // Build the filename with timestamp
    $filename = "receipt_{$timestamp}.pdf";

    // Download the PDF
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => "attachment; filename=\"$filename\"", // Specify the filename with timestamp
        'Pragma' => 'public',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Content-Transfer-Encoding' => 'binary',
        'Content-Length' => filesize($pdfPath),
    ];

    return response()->download($pdfPath, $filename, $headers)->deleteFileAfterSend(true);
}
}
