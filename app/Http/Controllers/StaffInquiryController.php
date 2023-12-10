<?php
// app/Http/Controllers/StaffInquiryController.php

namespace App\Http\Controllers;

use App\Models\ProductInquiry; // Make sure to import your model

class StaffInquiryController extends Controller
{
    public function index()
    {
        $inquiries = ProductInquiry::all();

        return view('staff.inquiries', compact('inquiries'));
    }

    public function reply($id)
    {
        $inquiry = ProductInquiry::findOrFail($id);
    
        // Validate the staff reply field, you can customize this based on your needs
        request()->validate([
            'staff-reply' => 'required|string',
        ]);
    
        // Append the original customer message to the staff reply
        $inquiry->staff_reply = request('staff-reply');
        $inquiry->save();
        
    
        return redirect()->route('staff.inquiries')->with('success', 'Reply submitted successfully');
    }
    
}
