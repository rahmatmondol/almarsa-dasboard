<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ResponseHelper;
use App\Notifications\ResetPassword as NotificationsResetPassword;
use App\Services\FirebaseDatabase;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    public $firebaseDatabase;
    public function __construct(FirebaseDatabase $firebaseDatabase)
    {
        $this->firebaseDatabase = $firebaseDatabase;
    }

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
                'image' => url('/assets/images/avatar/av-1.svg'),
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

            // send notification to admin
            $this->firebaseDatabase->create('/notifications/admin', [
                'created_at' => now(),
                'read_at' => false,
                'data' => [
                    'url' => 'customer/show/' . $user->id,
                    'avatar' =>  $user->image,
                    'name' =>  $user->name,
                    'message' =>  $user->name . ' is a new registered customer',
                ],
                'title' => 'New Customer Registered',
            ]);

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // register admin
    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // check user role
        if (!auth()->user()->hasRole('super-admin')) {
            return response()->json(['error' => 'Only admin users can register new admin users.'], 403);
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'image' => url('/assets/images/avatar/av-1.svg'),
            ]);

            // asing role
            $user->assignRole('admin');

            $data = [
                'success' => true,
                'message' => 'Admin registered successfully',
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
                    if ($user->image != url('/assets/images/avatar/av-1.svg')) {
                        $relativePath = parse_url($user->image, PHP_URL_PATH);
                        if (file_exists(public_path($relativePath))) {
                            unlink(public_path($relativePath)); // Deletes the file
                        }
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
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $user = User::whereEmail($request->email)->first();

            // Generate a token for the user
            $token = random_int(100000, 999999);

            $existingToken = DB::table('password_reset_tokens')->where('email', $user->email)->first();
            if ($existingToken) {
                DB::table('password_reset_tokens')->where('email', $user->email)->update([
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                DB::table('password_reset_tokens')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
            }

            // Send password reset link
            $user->notify(new NotificationsResetPassword($token));

            return response()->json(['success' => true, 'message' => 'Password reset link sent on your email.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->code,
        ])->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Invalid code or email.'], 400);
        }

        $user = User::whereEmail($request->email)->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return response()->json(['success' => true, 'message' => 'Password has been reset successfully.']);
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
                return response()->json(['error' => 'The provided current password is incorrect.'], 401);
            }

            auth()->user()->update([
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['success' => true, 'message' => 'Password changed successfully']);
        } catch (\Exception $e) {
            // Provide a more descriptive error response if query fails
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
