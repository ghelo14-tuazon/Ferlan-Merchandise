<?php

namespace App\Models;
use Paginator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    public $timestamps = ['stock_added_at'];
    protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition', 'stock_added_at','added_stock_history','sold_stock','stock_small','stock_medium','stock_large'];

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');  
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    public static function getAllProduct(){
        return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }
    
    public function discountedPrice()
    {
        // Calculate the discounted price based on your discount logic
        // For example, if the discount is stored as a percentage:
        $discountedPrice = $this->price - ($this->price * $this->discount / 100);

        // If you have a minimum discounted price, you can add a check here
        // $minimumDiscountedPrice = 10; // Replace with your minimum discounted price
        // $discountedPrice = max($discountedPrice, $minimumDiscountedPrice);

        return $discountedPrice;
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }
    public function stockHistory()
    {
        return $this->hasMany(StockHistory::class, 'product_id');
    }
 
}
