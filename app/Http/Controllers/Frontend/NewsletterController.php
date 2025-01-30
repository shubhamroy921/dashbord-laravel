<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;


class NewsletterController extends Controller
{

    public function storeEmail(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email|unique:newsletters,email',
            ]);

            // Retrieve the authenticated user's ID (or null if not authenticated)
            $user_id = auth()->id(); // Or $request->user()?->id

            // Store the email and user_id
            Newsletter::create([
                'email' => $request->email,
                'user_id' => $user_id
            ]);

            // Return a success response
            return back()->with('success', 'Thank you for subscribing');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect back with validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other potential exceptions
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

}
