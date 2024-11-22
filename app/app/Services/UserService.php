<?php 

namespace App\Services;

use App\Models\User;
class UserService {
    public function getUsers($request) {
        $model = new User();
        $users = User::whereHas('roles', function ($q) use ($request) {
            $q->when($request?->role, function ($q2) use ($request) {
                $q2->where('name', $request->role);
            });
        })->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);

        return $users;
    }

    public function showUser($request) {
        return User::find($request->id);
    }

    public function storeUser($request) {
        $user = User::create($request->all());
        $user->assignRole(['staff']);
    }

    public function updateUser($request) {
        User::find($request->id)->update($request->all());
    }

    public function deleteUser($request) {
        User::find($request->id)->delete();
    }

    public function getUserCount() {
        return User::count();
    }
}