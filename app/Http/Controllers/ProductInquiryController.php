<?php
// app/Http/Controllers/ProductInquiryController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductInquiry;
use Illuminate\Http\Request;

class ProductInquiryController extends Controller
{
    public function submit(Request $request)
{
    // Validate the form data
    $request->validate([
        'inquiry-name' => 'required|string|max:255',
        'inquiry-email' => 'required|email|max:255',
        'inquiry-message' => 'required|string',
    ]);

    // Create a new ProductInquiry model and save it to the database
    $inquiry = new ProductInquiry();
    $inquiry->name = $request->input('inquiry-name');
    $inquiry->email = $request->input('inquiry-email');
    $inquiry->message = $request->input('inquiry-message');
    $inquiry->staff_reply = $request->input('staff-reply');
    
    // Store the user's ID if authenticated
    if (Auth::check()) {
        $inquiry->user_id = Auth::id(); // Assuming user_id is the foreign key in the product_inquiries table
    }
    
    $inquiry->save();

    return redirect()->back()->with('success', 'Inquiry submitted successfully!');
}

    public function deleteInquiry($id)
{
    $inquiry = ProductInquiry::findOrFail($id);
    $inquiry->delete();

    return redirect()->route('staff.inquiries')->with('success', 'Inquiry deleted successfully');
}
}
