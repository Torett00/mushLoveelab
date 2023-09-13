<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\SignupRequest;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{
    public function indexx(){
        $userss = User::all();
        return response()->json($userss);
    }

    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role'=>$data['role'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;
        event(new Registered($user));
        return response(compact('user', 'token'));
    }
    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);
        if (!Auth::attempt($attr)) {
            return response()->json([
                'message' => 'Invalid login details'
                           ], 401);
        }
        $token = auth()->user()
              ->createToken('auth_token')->plainTextToken;
        $user = auth()->user();
  
        $respon = [
                'status' => 'success',
                'msg' => 'Login successfully',
                'content' => [
                    'status_code' => 200,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_id' => $user->id,
                    'role'=>$user->role,
                ]
            ];
   
            return response()->json($respon, 200);
    }
    
}