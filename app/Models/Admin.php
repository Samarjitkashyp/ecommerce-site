<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * THE ATTRIBUTES THAT ARE MASS ASSIGNABLE
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_super_admin',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * THE ATTRIBUTES THAT SHOULD BE HIDDEN
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * THE ATTRIBUTES THAT SHOULD BE CAST
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_super_admin' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * CHECK IF ADMIN IS SUPER ADMIN
     */
    public function isSuperAdmin()
    {
        return $this->is_super_admin || $this->role === 'super_admin';
    }

    /**
     * CHECK IF ADMIN HAS PERMISSION
     */
    public function hasPermission($permission)
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Define role-based permissions
        $permissions = [
            'admin' => [
                'dashboard.view',
                'orders.view',
                'products.view',
                'categories.view',
                'menus.view'
            ],
            'manager' => [
                'dashboard.view',
                'orders.view',
                'orders.manage',
                'products.view',
                'products.manage',
                'categories.view'
            ],
            'editor' => [
                'dashboard.view',
                'products.view',
                'products.manage',
                'categories.view',
                'categories.manage'
            ]
        ];

        return in_array($permission, $permissions[$this->role] ?? []);
    }

    /**
     * UPDATE LAST LOGIN INFO
     */
    public function updateLastLogin($request)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);
    }
}