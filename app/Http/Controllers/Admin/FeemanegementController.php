<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeemanegementController extends Controller
{

    // Display a list of students and fees // Display a list of students and their fees
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch students with their fees, optionally filter by search
        $students = Student::with('fees') // Eager load the fees relationship
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            })->paginate(10);

        return view('admin.feesmanegement.index', compact('students'));
    }
    public function create()
    {

        return view('admin.feesmanegement.create');
    }
    // Collect fee for a specific student  // Collect fee for a specific student
    public function collect(Request $request, $id)
    {
        // Retrieve the student by ID
        $student = Student::findOrFail($id);

        // If it's a POST request, process fee collection
        if ($request->isMethod('post')) {
            // Validate the request data
            $validated = $request->validate([
                'amount' => 'required|numeric|min:0',
            ]);

            // Store fee in the fees table
            $student->fees()->create([
                'amount' => $validated['amount'],
                'payment_date' => now(),
            ]);

            // Redirect back with success message
            return redirect()->route('fees.index')->with('success', 'Fee collected successfully!');
        }

        // If it's a GET request, return the view to collect the fee amount
        return view('admin.feesmanegement.collect', compact('student'));
    }

    // public function showFeeGraph($studentId)
    // {
    //     $student = Student::with('fees')->findOrFail($studentId);

    //     // Initialize the array to hold fees by month (Jan - Dec)
    //     $monthlyFees = array_fill(0, 12, null); // [null, null, ...]

    //     // Loop through fees and populate the monthly data
    //     foreach ($student->fees as $fee) {
    //         $month = $fee->payment_date->format('n') - 1; // Month as index (0 for Jan, 11 for Dec)
    //         $monthlyFees[$month] = $fee->amount;
    //     }

    //     return view('admin.feesmanegement.graph', compact('student', 'monthlyFees'));
    // }
    public function showFeeGraph($studentId)
{
    $student = Student::with('fees')->findOrFail($studentId);

    // Initialize the array to hold fees by month (Jan - Dec)
    $monthlyFees = array_fill(0, 12, 0); // Initialize with 0 instead of null

    // Loop through fees and populate the monthly data
    foreach ($student->fees as $fee) {
        // Check if payment_date is not null before formatting
        if ($fee->payment_date) {
            $month = $fee->payment_date->format('n') - 1; // Month as index (0 for Jan, 11 for Dec)
            $monthlyFees[$month] += $fee->amount; // Add to total for that month
        }
    }

    return view('admin.feesmanegement.graph', compact('student', 'monthlyFees'));
}



}
