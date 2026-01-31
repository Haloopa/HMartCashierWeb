<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users')); 
    }

    public function create()
    {
        return view('admin.users.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index') 
            ->with('success', 'Kasir berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $todayTransactions = $user->transactions()
            ->whereDate('created_at', today())
            ->count();
            
        $totalTransactions = $user->transactions()->count();
        $totalRevenue = $user->transactions()->sum('total_amount');
        
        return view('admin.users.show', compact('user', 'todayTransactions', 'totalTransactions', 'totalRevenue'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); 
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Data kasir berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->transactions()->count() > 0) {
            return redirect()->route('admin.users.index') 
                ->with('error', 'Tidak dapat menghapus kasir yang memiliki transaksi');
        }

        $user->delete();
        
        return redirect()->route('admin.users.index') 
            ->with('success', 'Kasir berhasil dihapus');
    }
}