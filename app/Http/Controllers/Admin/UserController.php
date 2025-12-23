<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        // Show all users except current admin
        $users = User::where('id', '!=', auth()->id())
            ->withCount('results')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function changeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()
            ->with('success', 'Role user berhasil diubah menjadi ' . ucfirst($request->role) . '.');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Status user berhasil diubah.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123';

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil direset menjadi: ' . $newPassword);
    }

    public function destroy(User $user)
    {
        // Prevent deleting self (already handled by index query, but good for safety)
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()
            ->with('success', 'User berhasil dihapus.');
    }
}
