<?php

namespace App\Http\Controllers;

use App\Models\email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;
use Laravel\Passport\Token;


class UserController extends Controller
{

    // login route -> login controller method -> return login page view -> html
    // login page view -> login.js -> ajax call -> json response (success/fail) -> on success ->redirect dashboard
    // dashboard route -> return dashboard view
    // dashboard view -> dashboard.js -> ajax call -> json response


    public function addUsers(Request $request){
        $request->validate([
            'email'=>'unique:users',
        ]);
        $user = new User;
        $user->first_name= $request->firstname;
        $user->last_name= $request->lastname;
        $user->email= $request->email;
        $user->age= $request->age;
        $user->password= $request->password;
        $user->country= $request->country;
        $user->save();
        return response()->json([
            'success' => true,
        ]);
    }
    public function validateLogin(Request $request){
        $input = $request->all();
        if (Auth::attempt(['email' => $input['email'],'password' => $input['password']])) {
            $user  = Auth::user();
            
            return response()->json([
                'success' => true,
                'access_token' => 'Bearer '.$user->createToken("login")->accessToken,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }else{
            return response()->json([
                ['error' => 'Invalid credentials'], 401
            ]);
        }
    }
    public function updateUserForm(Request $request){
        $user=Auth::guard('api')->user();
        $photo = DB::table('userPhotos')->join('users','users.id','userPhotos.user_id')
        ->where('userPhotos.user_id',$user->id)->first();
        return response()->json([
            'success' => true,
            'user' => $user,
            'photo' => $photo
        ]);
    }
    public function updateUser(Request $request){
        
            $user=Auth::guard('api')->user();
            DB::table('users')->where('id',$user->id)->update([
                'first_name'=>$request->firstname,
                'last_name'=>$request->lastname,
                'age'=>$request->age
            ]);
            $file=$request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('upload', $fileName, 'public');
            move_uploaded_file($file->getRealPath(), $filePath);
            DB::table('userPhotos')
            ->insert(['file_name'=>$fileName,'file_path'=>$filePath,'user_id'=>$user->id]);
            return response()->json([
                'success' => true,
            ]);
    }

    public function logout(Request $request){
        $user=Auth::guard('api')->user();
        $user->tokens()->delete();
        return response()->json([
            'success' => true,
        ]);
    

    }


    public function sessionCheck(){
        
            return view('home');
    }
}
