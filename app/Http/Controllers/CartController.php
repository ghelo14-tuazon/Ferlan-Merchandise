<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;
class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request)
    {
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }
    
        $product = Product::where('slug', $request->slug)->first();
    
        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }
    
        $already_cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->first();
    
        if ($already_cart) {
            $already_cart->quantity += 1;
            $already_cart->amount = $product->discountedPrice() * $already_cart->quantity;
    
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }
    
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->discountedPrice();
            $cart->quantity = 1;
            $cart->amount = $product->discountedPrice() * $cart->quantity;
    
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }
    
            $cart->save();
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
    
        request()->session()->flash('success', 'Product successfully added to cart');
        return back();
    }
    public function singleAddToCart(Request $request)
    {


        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
            'size' => 'required|in:Small,Medium,Large', 
         
        ]);
    
        $product = Product::where('slug', $request->slug)->first();
    
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Out of stock, You can add other products.');
        }
    
        if (($request->quant[1] < 1) || empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }
    
        $already_cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->where('size', $request->size) // Check for the cart size
            ->first();
    
        if ($already_cart) {
            $already_cart->quantity += $request->quant[1];
            $already_cart->amount = $product->discountedPrice() * $already_cart->quantity;
            $already_cart->size = $request->size; 
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }
    
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->discountedPrice();
            $cart->quantity = $request->quant[1];
            $cart->amount = $product->discountedPrice() * $request->quant[1];
            $cart->size = $request->size;
    
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }
    
            $cart->save();
        }
    
        request()->session()->flash('success', 'Product successfully added to cart.');
        return back();
    }
    
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Cart successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->product->stock < $quant){
                        request()->session()->flash('error','Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;
                    
                    if ($cart->product->stock <=0) continue;
                    $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }

    
    public function checkout(Request $request){
     
        return view('frontend.pages.checkout');
    }
}
