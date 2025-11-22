<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
   public function index()
    {
         $admins = User::where('role', 'admin')->get();
        return view('admin.users.index', compact('admins'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil dibuat!');
    }
     public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return back()->with('success', 'Admin berhasil dihapus!');
    }
     
}
