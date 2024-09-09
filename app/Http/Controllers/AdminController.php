<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function index(){
        try{
            $user = User::all();

            return response()->json([
                "response_code"=>"200",
                "response_message"=> "Berhasil mendapatkan data user!",
                "data" =>$user
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                "response_code"=>"500",
                "response_message"=> $th->getMessage(),
            ],500);
        }
    }
    public function show($id){
        try{
            $user = User::where('id',$id)->first();

            return response()->json([
                "response_code"=>"200",
                "response_message"=> "Berhasil mendapatkan data user!",
                "data" =>$user
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                "response_code"=>"500",
                "response_message"=> $th->getMessage(),
            ],500);
        }
    }
    public function create_user(Request $request){
        try{
            $request->validate([
                "email" => "required|unique:users,email|email",
                "name" => "required",
                "password" => "required|confirmed|min:6",
            ]);
    
            $user = User::create([
                "email" => $request->email,
                "name" => $request->name,
                "password" => Hash::make($request->password)
            ]);
    
            return response()->json([
                "response_code" => "200",
                "response_message" => "Berhasil Registrasi!",
                "data" => $user
            ], 201);

        } catch(\Throwable $th){
            return response()->json([
                "response_code" => "500",
                "response_message" => "Terjadi Kesalahan",
                "error" => $th->getMessage(),
            ], 500);
        }
      
    }
    public function update_user(Request $request,$id){
        try{
            $user = User::findOrfail($id);
            if(!$user){
                return response()->json([
                    "response_code" => "404",
                    "response_message" => "User Tidak ditermukan!",
                    "data" => $user
                ], 404);
            }
            $user->update([
                "email" => $request->email,
                "name" => $request->name,
            ]);

            $user->save();
    
            return response()->json([
                "response_code" => "200",
                "response_message" => "Berhasil Update User!",
                "data" => $user
            ], 201);
            
        } catch(\Throwable $th){
            return response()->json([
                "response_code" => "500",
                "response_message" => $th->getMessage(),
            ], 500);
        }
      
    }
    public function delete_user(Request $request,$id){
        try{
            User::destroy($id);
            return response()->json([
                'response_code' => "00",
                'response_message' => 'Berhasil delete id:' . ' ' . $id
            ]);
        } catch(\Throwable $th){
            return response()->json([
                "response_code" => "500",
                "response_message" => $th->getMessage(),
            ], 500);
        }
      
    }
}
