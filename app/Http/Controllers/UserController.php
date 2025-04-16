<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:admin,distributor',
            'status' => 'required|in:on,off',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $validated = $validator->validated();

            $user = new User();
            $user->username = $validated['username'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone_number = $validated['phone_number'];
            $user->role = $validated['role'];
            $user->status = $validated['status'] === 'on' ? 1 : 0;
            $user->save();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'required|string|max:20',
            // 'role' => 'required|in:admin,distributor',
            'status' => 'nullable|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $validated = $validator->validated();

            $user->username = $validated['username'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->phone_number = $validated['phone_number'];
            $user->role = $validated['role'] ?? $user->role;
            $user->status = $validated['status'];
            $user->save();

            DB::commit();
            if($user->role == 'distributor') {
                return redirect()->route('distributors.index')->with('success', 'User updated successfully');
            }
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $request->status == "1" ? 1 : 0;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
