<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function all(Request $request)
    {

        $roles = $request->input('roles');
        $limit = $request->input('limit', 200);

        $users = User::query();

        if($roles)
        {
            $users->where('roles', 'like', '%'. $roles . '%');
        }

        return ResponseFormatter::success(
            $users->paginate($limit),
            'Data List User Berhasil Di Ambil!'
        );



    }

    public function login(Request $request){
     try{
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ],[
            'email.required' => 'Silahkan masukan email yang valid!',
            'password.required' => 'Silahkan masukan password yang benar!'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return ResponseFormatter::error([
               'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }

        $user = User::where('email', $request->email)->first();
        if(!Hash::check($request->password, $user->password)){
            throw new \Exception('Invalid Credentials');
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'Authentication');
        }catch(Exception $error){
        return ResponseFormatter::error([
            'message' => 'Something Went Wrong',
            'error' => $error,
        ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'address' => 'required|string',
                'houseNumber' => 'required|string',
                'phoneNumber' => 'required|string',
                'city' => 'required|string',
                'postal_code' => 'required|integer',
                'kecamatan' => 'required|string|max:255'
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'address' => $data['address'],
                'houseNumber' => $data['houseNumber'],
                'phoneNumber' => $data['phoneNumber'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'kecamatan' => $data['kecamatan']
            ]);

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil!');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile updated');
    }

     public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Photo Fails', 401);
        }

        if ($request->file('file')) {

            $file = $request->file->store('assets/user', 'public');

            //store your file into database
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }
    }

}
