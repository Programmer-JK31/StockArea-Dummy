<?php

namespace App\Services;

use App\Models\User;
use App\Models\Shelf;
use App\Models\ShelfHasBook;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function getUserWithShelves(int $userId, bool $loadBooks = false): array
    {
        $user = User::findOrFail($userId);
        $shelves = Shelf::where('user_id', $userId)->get();

        $shelfData = $shelves->mapWithKeys(function ($shelf) use ($loadBooks) {
            if ($loadBooks) {
                $books = ShelfHasBook::where('shelf_id', $shelf->id)
                    ->get()
                    ->pluck('book_id');
                return [$shelf->name => $books];
            }
            return [$shelf->name];
        });

        return [
            'user' => $user,
            'shelves' => $shelfData
        ];
    }

    public function createUser(array $validatedData): User
    {
        return User::create($validatedData);
    }

    public function deleteUser(int $userId): void
    {
        User::findOrFail($userId)->delete();
    }

    public function getAllUsersPaginated(int $perPage = 3): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }
}
