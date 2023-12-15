<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\DailySale;
use App\Models\Order;
use App\Models\WalkinSale;
use App\Models\Shipping;
use App\User;
use Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class StaffOrderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('staff.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'string|required',
            'last_name'=>'string|required',
            'address1'=>'string|required',
            'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'post_code'=>'string|nullable',
            'email'=>'string|required'
        ]);
        // return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
            }
        }
        else{
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        $order_data['status']="new";
        if(request('payment_method')=='paypal'){
            $order_data['payment_method']='paypal';
            $order_data['payment_status']='paid';
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='Unpaid';
        }
        $order->fill($order_data);
        $status=$order->save();
        if($order)
        // dd($order->id);
        $users=User::where('role','admin')->first();
        $details = [
            'title' => 'New orcreated',
            'actionsURL' => route('staff.order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        
        Notification::send($users, new StatusNotification($details));
        if(request('payment_method')=='paypal'){
            return redirect()->route('payment')->with(['id'=>$order->id]);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);        
        request()->session()->flash('success','Your product successfully placed in order');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('products')->find($id);
    
        // Load the products relationship
        $order->load('cart.product');
    
      
    return view('staff.order.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('staff.order.edit')->with('order',$order);
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
        $order = Order::find($id);
    
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel,ready,shipout'
        ]);
    
        $data = $request->all();
    
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
    
                // Deduct stock based on size
                $size = $cart->size;
                switch ($size) {
                    case 'Small':
                        $product->stock_small -= $cart->quantity;
                        break;
                    case 'Medium':
                        $product->stock_medium -= $cart->quantity;
                        break;
                    case 'Large':
                        $product->stock_large -= $cart->quantity;
                        break;
                    case '41':
                        $product->stock_small -= $cart->quantity;
                        break;
                    case '42':
                        $product->stock_medium -= $cart->quantity;
                        break;
                    case '43':
                        $product->stock_large -= $cart->quantity;
                        break;
                    // Add more cases if you have other size options
    
                    // Deduct stock for the general 'stock' column
                }
    
                // Update sold_stock for all sizes
                $product->sold_stock += $cart->quantity;
                $product->stock -= $cart->quantity;
    
                $product->save();
            }
        }
    
        $status = $order->fill($data)->save();
    
        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('staff.order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed. please wait.');
            return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is under processing please wait.');
                return redirect()->route('home');
    
            }
            elseif($order->status=="ready"){
                request()->session()->flash('success','The product is prepared and ready for swift delivery to your doorstep!');
                return redirect()->route('home');
    
            }
            elseif($order->status=="shipout"){
                request()->session()->flash('success','Your product is currently out for delivery, making its way to your doorstep. Anticipate its arrival shortly!');
                return redirect()->route('home');
    
            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is successfully delivered.');
                return redirect()->route('home');
    
            }
            else{
                request()->session()->flash('error','Your order canceled. please try again');
                return redirect()->route('home');
    
            }
        }
        else{
            request()->session()->flash('error','Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    //public function pdf(Request $request){
       // $order=Order::getAllOrder($request->id);
        // return $order;
        //$file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
       // $pdf=PDF::loadview('staff.order.pdf',compact('order'));
        //return $pdf->download($file_name);
   // }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    public function dailySales()
    {
        $dailySales = $this->getDailySales();
        return view('staff.dailysale.dailysales')->with('dailySales', $dailySales);
    }
  
    private function getDailySales()
    {
        $today = Carbon::now()->toDateString();
    
        // Check if a record exists for the current date
        $dailySale = DailySale::whereDate('date', $today)->first();
    
        if (!$dailySale) {
            // If no record exists, create a new one
            $dailySale = DailySale::create([
                'date' => $today,
                'online_sales' => 0,
                'walkthrough_sales' => 0,
                'total_sales' => 0,
            ]);
        }
    
        // Calculate online sales from orders
        $onlineSales = Order::whereDate('created_at', $today)
            ->where('status', 'delivered')
            ->with(['cart_info'])
            ->get()
            ->sum(function ($order) {
                return $order->cart_info->sum('amount');
            });
    
        // Fetch walkthrough sales from the "walkin_sales" database
        $walkthroughSalesFromWalkinSalesDB = WalkinSale::whereDate('created_at', $today)->sum('total_price');
    
        // Get walkthrough sales from the daily sales record
        $walkthroughSales = $dailySale->walkthrough_sales;
    
        // Update the online sales, walkthrough sales, and total sales in the daily sales record
        $dailySale->update([
            'online_sales' => $onlineSales,
            'walkthrough_sales' => $walkthroughSalesFromWalkinSalesDB,
            'total_sales' => $onlineSales + $walkthroughSalesFromWalkinSalesDB,
        ]);
    
        // Retrieve all daily sales after the update with pagination
        $allDailySales = DailySale::orderBy('date', 'desc')->paginate(4);
    
        return [
            'date' => $today,
            'online_sales' => $dailySale->online_sales,
            'walkthrough_sales' => $dailySale->walkthrough_sales,
            'total_sales' => $dailySale->total_sales,
            'all_daily_sales' => $allDailySales, // Include all daily sales in the result
        ];
    }
    public function updateDailySales(Request $request)
    {
        $walkthroughSales = $request->input('walkthrough_sales');
        $today = Carbon :: now()->toDateString();
    
        // Check if a record exists for the current date
        $dailySale = DailySale::whereDate('date', $today)->first();
    
        if (!$dailySale) {
            // If no record exists, create a new one
            $dailySale = DailySale::create([
                'date' => $today,
                'online_sales' => 0,
                'walkthrough_sales' => 0,
                'total_sales' => 0,
            ]);
        }
    
        // Update the walkthrough sales and total sales in the daily sales record
        $dailySale->update([
            'walkthrough_sales' => $walkthroughSales,
            'total_sales' => $dailySale->online_sales + $walkthroughSales,
        ]);
    
        // Save walkthrough sales to session
        session(['walkthrough_sales' => $walkthroughSales]);
    
        return redirect()->route('dailySales')->with('success', 'Walkthrough sales updated successfully.');
    }
   

    public function generatePdf($orderId)
    {
        $order = Order::find($orderId);
    
        // Fetch the products associated with the order
        $products = $order->cart()->with('product')->get();
    
        // Fetch the shipping charge for the order
        $shippingCharge = Shipping::where('id', $order->shipping_id)->value('price');
    
        // Calculate the item total by subtracting the shipping charge from the total amount
        $itemTotal = $order->total_amount - $shippingCharge;
    
        $pdf = PDF::loadView('staff.receipt.receipt', compact('order', 'products', 'itemTotal', 'shippingCharge'));
    
        // Set the PDF filename to the order number
        $pdfFileName = 'order_' . $order->order_number . '.pdf';
    
        return $pdf->download($pdfFileName);
    }
    
    
    public function productInventory()
    {
        // Fetch all products
        $products = Product::all();

        // Pass the product data to the view
        return view('staff.product.inventory', compact('products'));
    }
    public function purchaseProduct($productId, $quantity)
    {
        // Fetch the product
        $product = Product::findOrFail($productId);

        // Check if there is enough stock
        if ($product->stock >= $quantity) {
            // Calculate the new stock value
            $newStock = $product->stock - $quantity;

            // Update the product's stock in the database
            $product->update(['stock' => $newStock]);

            // You might also want to create an order and associate the product with it
            // Example: (Make sure to adjust this based on your actual logic)
            $order = new Order();
            $order->save();

            $cart = new Cart([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'amount' => $product->price * $quantity,
                // ... other necessary fields for your cart
            ]);

            $order->carts()->save($cart);

            return redirect()->route('product.inventory')->with('success', 'Product purchased successfully.');
        } else {
            return redirect()->route('product.inventory')->with('error', 'Not enough stock available.');
        }
    }
}

