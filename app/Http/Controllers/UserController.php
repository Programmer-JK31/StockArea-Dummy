<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use App\Models\shelfHasBook;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    function show(Request $request, $id){

        // We will fetch user object and also load his shelves
        // If load_books is coming as true, then load the books of the shelf as well.
        // Do check id is valid user_id and is not deleted.

        // Cheking user_id is valid and not deleted
        $user = User::find($id);
        if(!$user){
            return response()->json([
                "message" => "User do not exists"
            ],404);
        }

        $shelfdata = Shelf::where('user_id','=', $id)->get();

        // Handling loadbooks query param
        $loadBooks = $request->boolean('load_books', false);
        if($loadBooks){
            $data = [];
            foreach($shelfdata as $shelf){
                $data[$shelf['name']] = shelfHasBook::where('shelf_id',$shelf['id'])->get('book_id');
            }
        }else{
            $data = [];
            foreach($shelfdata as $shelf){
                $data[] = $shelf['name'];
            }
        }
        return response()->json([
            "User" => $user,
            "Shelves" => $data
        ]);
    }

    function store(Request $request){
        //create user in database
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
            ]);

            $user = User::create($validatedData);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    function destroy($id){

        //soft deletes the user
        try{
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'message' => 'An error occured',
                'error' => $e->getMessage()
            ],500);
        }
    }

    function getAllUsers(){
        //You have to return all users, with pagination..
        //page limit you have to put 3
        $data = User::paginate(3);


        return response()->json($data, 200);
    }
}
