<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductReview;
use App\Notifications\StatusNotification;
use App\User;
use Notification;

class ProductReviewUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productSlug)

    {
        // Validate the request data
        $this->validate($request, [
            'rate' => 'required|numeric|min:1',
            'review' => 'required|string',
        ]);

        // Find the product by its slug
        $product = Product::where('slug', $productSlug)->first();

        // Check if the product exists
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        // Check if the user has already reviewed the product
        $existingReview = ProductReview::where('product_id', $product->id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product!');
        }

        // Create a new review
        $review = new ProductReview();
        $review->user_id = auth()->user()->id;
        $review->product_id = $product->id;
        $review->rate = $request->input('rate');
        $review->review = $request->input('review');
        $review->status = $request->input('status', 'approved'); // Default to pending if not provided
        $review->save();

        // Notify admin about the new review
        $user = User::where('role', 'admin')->get();
        $details = [
            'title' => 'New Product Review!',
            'actionURL' => route('product-detail', $product->slug),
            'fas' => 'fa-star',
        ];
        Notification::send($user, new StatusNotification($details));

        return redirect()->back()->with('success', 'Thank you for your review! It will be visible after approval.');
    }
   
// ProductDetail.php
public function deleteReview($id)
{
    $review = ProductReview::findOrFail($id);

    // Check if the logged-in user is the owner of the review
    if (auth()->user()->id == $review->user_info->id) {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    return redirect()->back()->with('error', 'You do not have permission to delete this review.');
}


}
