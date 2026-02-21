<?php
// app/Http/Controllers/AddressController.php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('account.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|size:10',
                'pincode' => 'required|string|size:6',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'landmark' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'type' => 'required|in:home,office,other',
            ]);

            $validated['user_id'] = auth()->id();
            
            // If this is first address or set as default
            $existingAddresses = Address::where('user_id', auth()->id())->count();
            $validated['is_default'] = $existingAddresses === 0 || $request->boolean('is_default');

            // If setting as default, remove default from others
            if ($validated['is_default']) {
                Address::where('user_id', auth()->id())
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            $address = Address::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Address added successfully!',
                'address' => $address
            ]);

        } catch (\Exception $e) {
            Log::error('Add address error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add address.'
            ], 500);
        }
    }

    public function update(Request $request, Address $address)
    {
        try {
            // Check ownership
            if ($address->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|size:10',
                'pincode' => 'required|string|size:6',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'landmark' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'type' => 'required|in:home,office,other',
            ]);

            // Handle default address
            if ($request->boolean('is_default') && !$address->is_default) {
                Address::where('user_id', auth()->id())
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
                $validated['is_default'] = true;
            }

            $address->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Update address error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update address.'
            ], 500);
        }
    }

    public function destroy(Address $address)
    {
        try {
            if ($address->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete address error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete address.'
            ], 500);
        }
    }

    public function setDefault(Address $address)
    {
        try {
            if ($address->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Remove default from all addresses
            Address::where('user_id', auth()->id())
                ->where('is_default', true)
                ->update(['is_default' => false]);

            // Set this as default
            $address->is_default = true;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Default address updated!'
            ]);

        } catch (\Exception $e) {
            Log::error('Set default address error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to set default address.'
            ], 500);
        }
    }
}