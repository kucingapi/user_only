<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:5',
            'password' => 'required|min:5',
        ]);
        $user = new User();
        $username = $request->username;
        $password = $request->password;

        $user->username = $username;
        $user->password = $password;
        try {
            $user->save();
            return response()->json(['status' => 'success', 'message' => "user has been created"]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function getAllUser(){
        $users = User::all();
        return response()->json(['status' => 'success', 'users' => $users]);
    }
    public function updateUser(Request $request){
        $this->validate($request, [
            'username' => 'required|min:5',
        ]);
        $username = $request->username;
        $password = $request->password;
        $user = User::where('username', $username)->first();
        if($password == null){
            $password = $user->password;
        }
        $user->password = $password;
        $user->save();
        return response()->json(['status' => 'success', 'user' => $user, 'password' => $password]);
    }
    public function deleteUser(Request $request){
        $this->validate($request, [
            'username' => 'required|min:5',
        ]);
        $username = $request->username;
        $password = $request->password;
        $user = User::where('username', $username)->first();
        if($password == $user->password){
            $user->delete();
            return response()->json(['status' => 'success', 'message' => "user deleted"]);
        }
        else{
        return response()->json(['status' => 'failed', 'message' => "wrong password"]);
        }
    }
}
