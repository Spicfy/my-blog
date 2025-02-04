<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    //
    public function updateProfile(Request $request)
    {
        if(!Auth::check()){
            return response()->json(['message'=> 'Unauthenticated.'], 401);
        }
        $user = Auth::user();
        if (!$user instanceof User) {
            return response()->json(['message' => 'User model not found.'], 500);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->save();
        return response()->json(['message' => 'Profile has been updated successfully'], 200);
    }

    public function changePassword(Request $request){
        
        if(!Auth::check()){
            return response()->json(['message'=> 'Unauthenticated.'], 401);
        }

        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed' // 'confirmed' checks if new_password_confirmation is present
            
        
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::user();
        if (!$user instanceof User) {
            return response()->json(['message' => 'User model not found.'], 500);
        }
        if(!Hash::check($request->current_password, $user->password)){
            return response()->json(['message'=> 'Current password does not match'], 422);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message'=> 'Password changed successfuully.'], 200);
    }
        public function changeEmail(Request $request){
            $validator = Validator::male($request->all(), [
                'email'=> 'required|string|email|max:255|unique:users',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=> $validator->errors()], 422);
            }
            $user = Auth::user();
            if (!$user instanceof User) {
                return response()->json(['message' => 'User model not found.'], 500);
            }
            $user->email= $request->input('email');
            $user->save();
            return response()->json(['message'=> 'Email changed successfully.'], 200);
        
    }
}
