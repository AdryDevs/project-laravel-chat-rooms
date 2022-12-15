<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    const SUPER_ADMIN_ROLE = 1;
    const ADMIN_ROLE = 2;
    const USER_ROLE = 3;

    public function addSuperAdminRoleByIdUser($id){

        try {
            $userId = $id;
            $user = User::find($userId);

            if(!$user){
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->roles()->attach(self::SUPER_ADMIN_ROLE);

            return response()->json([
                'success' => true,
                'message' => 'Super Admin role added successfully'
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Error adding super admin role to user: " . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error adding super admin role to user'
            ], 500);
        }
    }
}
