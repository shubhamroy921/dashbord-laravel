<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the staffs.
     */

    public function index(Request $request)
    {
        $query = Staff::query();

        // Check if a search query is provided
        if ($request->has('search')) {
            $search = $request->input('search');
            // Search for staffs by name, father's name, or mother's name
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('father_name', 'LIKE', "%{$search}%")
                ->orWhere('mother_name', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%")
                ->orWhere('gender', 'LIKE', "%{$search}%")
                ->orWhere('dob', 'LIKE', "%{$search}%")
                ->orWhere('alternate_number', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%");
        }

        // Paginate the results
        $staffs = $query->paginate(20);

        return view('admin.staffs.index', compact('staffs'));
    }


    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('admin.staffs.create'); // Return a view to create a staff
    }

    /**

    * Store a newly created staff in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_photo' => 'nullable|image|max:6048',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|numeric|digits:10', // Example for stricter validation
            'alternate_number' => 'nullable|numeric|digits:10',
            'role' => 'required|string|max:255', // Added 'required'
            'email' => 'required|email|max:255',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:6048', // Accept PDF and images only
        ]);

        // Create a new staff instance
        $staffData = $request->except(['staff_photo', 'document']);

        // Handle staff photo upload
        if ($request->hasFile('staff_photo')) {
            $path = $request->file('staff_photo')->store('staff_photos', 'public');
            $staffData['staff_photo'] = $path;
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $staffData['document'] = $path;
        }

        // Save the staff data to the database
        Staff::create($staffData);

        return redirect()->route('staffs.index')->with('success', 'Staff created successfully.');
    }



    /**
     * Display the specified staff.
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id); // Fetch specific staff
        return view('admin.staffs.show', compact('staff')); // Return a view with staff data
    }

    /**
     * Show the form for editing the specified staff.
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id); // Fetch specific staff to edit
        return view('admin.staffs.edit', compact('staff')); // Return a view to edit staff
    }

    /**
     * Update the specified staff in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the staff by ID
        $staff = Staff::findOrFail($id);

        $request->validate([
            'staff_photo' => 'nullable|image|max:6048',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|numeric|digits:10',
            'alternate_number' => 'nullable|numeric|digits:10',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            'document' => 'nullable|file|max:6048',
        ]);

        // Handle photo removal
        if ($request->input('remove_photo') == '1') {
            if ($staff->staff_photo) {
                // Delete the old photo
                Storage::disk('public')->delete($staff->staff_photo);
                $staff->staff_photo = null;
            }
        }

        // Handle staff photo upload
        if ($request->hasFile('staff_photo')) {
            if ($staff->staff_photo) {
                // Delete the old photo if a new one is uploaded
                Storage::disk('public')->delete($staff->staff_photo);
            }
            $path = $request->file('staff_photo')->store('staff_photos', 'public');
            $staff->staff_photo = $path;
        }
        if ($request->hasFile('document')) {
            // Delete the old document if necessary
            if ($staff->document) {
                Storage::disk('public')->delete($staff->document);
            }

            // Store the new document
            $path = $request->file('document')->store('documents', 'public');
            $staff->document = $path;
        }

        // Save the updated staff information
        $staff->fill($request->except(['staff_photo', 'document']));
        $staff->save();

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully.');
    }



    /**
     * Remove the specified staff from storage.
     */
    public function destroy($id)
    {
        // Find the staff by ID
        $staff = Staff::findOrFail($id);

        // Delete the staff photo if it exists
        if ($staff->staff_photo) {
            Storage::disk('public')->delete($staff->staff_photo);
        }

        // Delete the document if it exists
        if ($staff->document) {
            Storage::disk('public')->delete($staff->document);
        }

        // Delete the staff record from the database
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
