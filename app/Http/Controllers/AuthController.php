<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            // asing role
            $user->assignRole('customer');

            // Generate a token for the user
            $token = JWTAuth::fromUser($user);

            $data = [
                'success' => true,
                'message' => 'User registered successfully',
                'token' => $token,
                'user' => $user
            ];

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'massage' => 'Invalid Credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = auth()->user();

        return response()->json(compact('token', 'user'));
    }

    // Logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Get current user (authenticated)
    public function me()
    {
        return response()->json(auth()->user());
    }

    // update profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'address2' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'max:255'],
            'phone' => ['required', 'unique:users,phone,' . auth()->user()->id],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        try {
            $user = auth()->user();
            $user->first_name = $request->first_name ?? null;
            $user->last_name = $request->last_name ?? null;
            $user->address = $request->address ?? null;
            $user->address2 = $request->address2 ?? null;
            $user->city = $request->city ?? null;
            $user->country = $request->country ?? null;
            $user->postal_code = $request->postal_code ?? null;
            $user->phone = $request->phone ?? null;
            $user->save();

            if ($request->hasFile('image')) {

                if ($user->image) {
                    $relativePath = parse_url($user->image, PHP_URL_PATH);
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath)); // Deletes the file
                    }
                }

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/users/', $filename);
                $user->image = url('uploads/users/' . $filename);
                $user->save();
            }

            $data = [
                'success' => true,
                'message' => 'User registered successfully',
                'user' => $user
            ];

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Refresh token
    public function refresh()
    {
        return response()->json(['token' => JWTAuth::refresh(JWTAuth::getToken())]);
    }

    // Forgot password
    public function forgotPassword(Request $request)
    {
        // Implement password reset logic
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        // Implement password reset logic
    }

    // Change password
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:8|confirmed|different:current_password',
                'current_password' => 'required|string|',
            ]);

            // Check if the current password is correct
            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return ResponseHelper::error('Current password is incorrect', 401);
            }

            auth()->user()->update([
                'password' => bcrypt($request->password),
            ]);

            return ResponseHelper::success('Password changed successfully');
        } catch (\Exception $e) {
            // Provide a more descriptive error response if query fails
            return ResponseHelper::error('Failed to change password: ' . $e->getMessage(), 500);
        }
    }
}
