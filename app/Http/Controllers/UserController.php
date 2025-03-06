<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostUser;
use App\Http\Requests\UserShowRequest;
use App\Http\Resources\UserResource;
use App\Models\Shelf;
use App\Models\shelfHasBook;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function show(UserShowRequest $request, $id){

        // We will fetch user object and also load his shelves
        // If load_books is coming as true, then load the books of the shelf as well.
        // Do check id is valid user_id and is not deleted.

        // Cheking user_id is valid and not deleted
        $validatedData = $request->validated();
        try{
            $userData = User::with('shelf.shelfHasBook.book')->find($id);
            $userData['loadBooks'] = $validatedData['load_books'];
            // $loadBooks = $validatedData['load_books'];
            // if($loadBooks == true) {
            //     $shelfData = [];
            //     // echo $userData->shelf;
            //     foreach($userData->shelf as $shelf){
            //         $bookData = $shelf->shelfHasBook->pluck('book.name');
            //         // foreach($shelf->shelfHasBook as $book){
            //         //     $bookData $book->book->name;
            //         // }
            //         $shelfData[$shelf->name] = $bookData;
            //     }
            // }else{
            //     $shelfData = $userData->shelf->pluck('name')->toArray();
            // }
            // $userData['shelfData'] = $shelfData;

            return new UserResource($userData);
        }catch(Exception $e){
            return response()->json([
                "msg" => $e->getMessage()
            ]);
        }

    }

    // function store(StorePostUser $request){
    //     //create user in database
    //     $validatedData = $request->validated();

    //     $user = User::create($validatedData);

    //     return response()->json([
    //         'message' => 'User created successfully',
    //         'user' => $user
    //     ], 201);
    // }

    // function destroy($id){

    //     //soft deletes the user
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return response()->json([
    //         'message' => 'User deleted successfully'
    //     ], 200);
    // }

    // function getAllUsers(){
    //     //You have to return all users, with pagination..
    //     //page limit you have to put 3
    //     $data = User::paginate(3);


    //     return response()->json($data, 200);
    // }
}

// Show :
    //We need a validation layer that checks id exists or not
    //Whatever we are loading should be loaded with eagar loading
    //We need a resource layer that handles any kind of response(loadbook = true or false)
    //We want all the code except validation layer in try-catch
    //Whatever errors we want to log that
