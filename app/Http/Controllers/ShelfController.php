<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignBook;
use App\Http\Requests\StoreShelf;
use App\Models\Shelf;
use App\Models\shelfHasBook;
use App\Models\User;

class ShelfController extends Controller
{
    function show($id){

        // You have to load the books relation always, user_name and user_email
        $shelf = Shelf::findOrFail($id);

        $user = User::findOrFail($shelf['user_id']);
        $data = shelfHasBook::where('shelf_id','=',$id)->get('book_id');

        return response()->json([
            "username" => $user['name'],
            "email" => $user['email'],
            "shelf name" => $shelf['name'],
            "books" => $data
        ]);
    }

    function store(StoreShelf $request){

        // have validation check that user should exists in the database.
        $validatedData = $request->validated();

        // $id = $validatedData['user_id'];
        // $user = User::findOrFail($id);

        // if(!$user){
        //     return response()->json([
        //         'message' => "User with user id $id not found",
        //     ], 404);
        // }

        $shelf = Shelf::create($validatedData);

        return response()->json([
            'message' => 'Shelf created successfully',
            'shelf' => $shelf
        ], 201);
    }

    function assignBook(StoreAssignBook $request){

        // We will check whether the book is not attached to any user.
        // Then we willl check that the shelf id coming actually
        // is being owned by the user id coming.
            $validatedData = $request->validated();

            // // Validating User
            // $userId = $validatedData['user_id'];
            // // $user = User::findOrFail($userId);
            // // if(!$user){
            // //     return response()->json([
            // //         'message' => "User with user id $userId not found",
            // //     ], 404);
            // // }

            // // // Validating Shelf
            // $shelfId = $validatedData['shelf_id'];
            // $shelf = Shelf::findOrFail($shelfId);
            // // if(!$shelf){
            // //     return response()->json([
            // //         'message' => "Shelf with shelf id $shelfId not found",
            // //     ], 404);
            // // }

            // // Validating book is not attached to any user
            // $bookId = $validatedData['book_id'];
            // $attachedBook = shelfHasBook::where('book_id', $bookId)->exists();
            // if($attachedBook){
            //     return response()->json([
            //         "message" => "Book is already attached to some user",
            //         "data" => $attachedBook
            //     ],200);
            // }

            // // Validating if particular shelf is owned by user
            // if($shelf['user_id'] != $userId){
            //     return response()->json([
            //         'message' => "Shelf is not owned by user"
            //     ],403);
            // }

            shelfHasBook::create($validatedData);

            return response()->json([
                "message" => "Book assiged to shelf successfully",
            ],200);
    }

    function getAllShelves(){
        // You have to return all shelves, with pagination,..
        // page limit you have to put 5.
        // You have to load books which are part of the shelf

        $data = [];

        return response()->json($data, 200);
    }
}
