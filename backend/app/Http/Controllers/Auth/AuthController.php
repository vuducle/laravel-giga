<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index() {}

    /**
     * Register a new user
     *
     * @group Auth
     * @bodyParam name string required The user's full name. Example: "Julia Nguyen"
     * @bodyParam email string required The user's email address. Example: "julianguyen@example.com"
     * @bodyParam password string required Password (min 8). Example: "JuliaNguyen>TriesnhaAmeilya98!"
     * @bodyParam password_confirmation string required Must match password. Example: "JuliaNguyen>TriesnhaAmeilya98!"
     * @bodyParam phone string nullable Optional phone number. Example: "+49123456789"
     *
     * @response 201 {
     *  "user": {"id": 1, "name": "Julia Nguyen", "email": "julianguyen@example.com"},
     *  "token": "plain-text-token",
     *  "message": "Register Successfully"
     * }
     */
    public function register(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|same:password',
            'phone' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Register Successfully',
        ]);
    }

    /**
     * Login and return API token
     *
     * @group Auth
     * @bodyParam email string required The user's email. Example: "julianguyen@example.com"
     * @bodyParam password string required The user's password. Example: "JuliaNguyen>TriesnhaAmeilya98!"
     *
     * @response 200 {
     *  "user": {"id": 1, "name": "Julia Nguyen", "email": "julianguyen@example.com"},
     *  "token": "plain-text-token",
     *  "message":"Login Successfully"
     * }
     */
    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login Successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $user->load(['listings', 'bookings.listing']);

        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|nullable|string',
            'bio' => 'sometimes|nullable|string|max:500',
            'location' => 'sometimes|nullable|string',
            'avatar' => 'sometimes|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = basename($path);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    public function becomeHost(Request $request)
    {
        $user = $request->user();

        if ($user->is_host) {
            return response()->json(['message' => 'Already a host'], 400);
        }

        $validated = $request->validate([
            'phone' => 'required|string',
            'location' => 'required|string',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update(array_merge($validated, ['is_host' => true]));
        $user->becomeHost();

        return response()->json([
            'message' => 'Congratulations! You are now a host.',
            'user' => $user,
        ]);
    }
}
