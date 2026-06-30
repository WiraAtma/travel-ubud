<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function page(Request $request)
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'superadmin']), 403);
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

    public function promote(User $user)
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'superadmin']), 403);
        abort_if(Auth::id() === $user->id, 403);
        abort_unless($user->role === 'user', 403);

        $user->update(['role' => 'admin']);

        return back()->with('success', "{$user->name} berhasil dijadikan admin.");
    }

    public function demote(User $user)
    {
        abort_unless(Auth::user()->role === 'superadmin', 403);
        abort_if(Auth::id() === $user->id, 403);
        abort_unless($user->role === 'admin', 403);

        $user->update(['role' => 'user']);

        return back()->with('success', "{$user->name} berhasil diturunkan menjadi pengguna biasa.");
    }
}