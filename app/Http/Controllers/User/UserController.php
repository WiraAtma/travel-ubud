<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function page(Request $request)
    {
        $role = $request->query('role', 'all');
        $search = $request->query('search');

        $users = User::orderBy('created_at', 'desc')
            ->when($role !== 'all', fn($q) => $q->where('role', $role))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();
            
        return view('features.admin.list-user-admin', compact('users', 'role'));
    }
}