<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;

interface UserRepositoryInterface
{
    public function countUsers();
}

class UserRepository
{
    public function countUsers()
    {
        return User::role('user')->count();
    }
    public function getUser($roleName, $user_id, $guard = 'web')
    {
        $userRole = Role::where('name', $roleName)->where('guard_name', $guard)->first();

        if (!$userRole) {
            // Handle the case where the "user" role doesn't exist
            return null;
        }

        $usersWithUserRole = $userRole->users()
            ->whereDoesntHave('roles', function ($query) use ($userRole) {
                $query->where('name', '<>', $userRole->name);
            })
            ->where('id', '!=', $user_id)->latest()
            ->paginate(10);

        return $usersWithUserRole;
    }
    public function getUserByRole($roleName, $user_id, $guard = 'web')
    {
        $role = Role::where('name', $roleName)->where('guard_name', $guard)->first();

        if (!$role) {
            return null;
        }

        $data = $role->users()
            ->where('id', '!=', $user_id)
            ->latest()
            ->paginate(10);

        return $data;
    }

    public function create($user)
    {
        try {
            return User::create($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
