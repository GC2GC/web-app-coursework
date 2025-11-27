<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users (admin only).
     */
    public function index()
    {
        $users = User::withCount(['posts', 'comments'])
            ->latest()
            ->paginate(15);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new user (admin only).
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created user (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_administrator' => ['boolean'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_administrator' => $request->has('is_administrator') ? true : false,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user with their posts and comments.
     */
    public function show(User $user)
    {
        $user->load([
            'posts' => function ($query) {
                $query->with('author')->latest();
            },
            'comments' => function ($query) {
                $query->with('post')->latest();
            }
        ]);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified user (admin only).
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}

