<?php
// app/Http/Controllers/Admin/CouponController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends AdminController
{
    /**
     * Display all coupons
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store new coupon
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|unique:coupons,code|max:50',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'min_order_amount' => 'nullable|numeric|min:0',
                'max_discount_amount' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'usage_per_user' => 'nullable|integer|min:1',
                'starts_at' => 'nullable|date',
                'expires_at' => 'nullable|date|after:starts_at',
                'is_active' => 'sometimes|boolean'
            ]);

            $validated['code'] = strtoupper($validated['code']);
            $validated['is_active'] = $request->has('is_active');

            $coupon = Coupon::create($validated);

            Log::info('Coupon created by admin', ['coupon_id' => $coupon->id, 'code' => $coupon->code]);

            return $this->sendSuccess(
                'Coupon created successfully!',
                ['coupon' => $coupon],
                route('admin.coupons.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Coupon creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create coupon: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Show edit form
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update coupon
     */
    public function update(Request $request, Coupon $coupon)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'min_order_amount' => 'nullable|numeric|min:0',
                'max_discount_amount' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'usage_per_user' => 'nullable|integer|min:1',
                'starts_at' => 'nullable|date',
                'expires_at' => 'nullable|date|after:starts_at',
                'is_active' => 'sometimes|boolean'
            ]);

            $validated['code'] = strtoupper($validated['code']);
            $validated['is_active'] = $request->has('is_active');

            $coupon->update($validated);

            Log::info('Coupon updated by admin', ['coupon_id' => $coupon->id, 'code' => $coupon->code]);

            return $this->sendSuccess(
                'Coupon updated successfully!',
                ['coupon' => $coupon],
                route('admin.coupons.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Coupon update error: ' . $e->getMessage());
            return $this->sendError('Failed to update coupon: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Delete coupon
     */
    public function destroy(Coupon $coupon)
    {
        try {
            $couponName = $coupon->name;
            $coupon->delete();

            Log::info('Coupon deleted by admin', ['coupon_id' => $coupon->id, 'name' => $couponName]);

            return response()->json([
                'success' => true,
                'message' => 'Coupon "' . $couponName . '" deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Coupon deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete coupon: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus(Coupon $coupon)
    {
        try {
            $coupon->is_active = !$coupon->is_active;
            $coupon->save();

            return response()->json([
                'success' => true,
                'message' => 'Coupon status updated!',
                'is_active' => $coupon->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Coupon status toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update coupon status'
            ], 500);
        }
    }
}