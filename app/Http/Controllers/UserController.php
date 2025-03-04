<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostUser;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// class UserController extends Controller
// {
//     function show(Request $request, $id){

//         // We will fetch user object and also load his shelves
//         // If load_books is coming as true, then load the books of the shelf as well.
//         // Do check id is valid user_id and is not deleted.

//         // Cheking user_id is valid and not deleted
//         $user = User::findOrFail($id);

//         $shelfdata = Shelf::where('user_id','=', $id)->get();

//         // Handling loadbooks query param
//         $loadBooks = $request->boolean('load_books', false);
//         if($loadBooks){
//             $data = [];
//             foreach($shelfdata as $shelf){
//                 $data[$shelf['name']] = shelfHasBook::where('shelf_id',$shelf['id'])->get('book_id');
//             }
//         }else{
//             $data = [];
//             foreach($shelfdata as $shelf){
//                 $data[] = $shelf['name'];
//             }
//         }

//         return response()->json([
//             "User" => $user,
//             "Shelves" => $data
//         ]);
//     }

//     function store(StorePostUser $request){
//         //create user in database
//         $validatedData = $request->validated();

//         $user = User::create($validatedData);

//         return response()->json([
//             'message' => 'User created successfully',
//             'user' => $user
//         ], 201);
//     }

//     function destroy($id){

//         //soft deletes the user
//         $user = User::findOrFail($id);
//         $user->delete();

//         return response()->json([
//             'message' => 'User deleted successfully'
//         ], 200);
//     }

//     function getAllUsers(){
//         //You have to return all users, with pagination..
//         //page limit you have to put 3
//         $data = User::paginate(3);


//         return response()->json($data, 200);
//     }
// }

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request, $id): JsonResponse
    {
        $data = $this->userService->getUserWithShelves(
            $id,
            $request->boolean('load_books', false)
        );

        return response()->json([
            'user' => new UserResource($data['user']),
            'shelves' => $data['shelves']
        ]);
    }

    public function store(StorePostUser $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'data' => new UserResource($user)
        ], 201);
    }

    public function destroy($id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function getAllUsers(): JsonResponse
    {
        $users = $this->userService->getAllUsersPaginated();
        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ]);
    }
}
