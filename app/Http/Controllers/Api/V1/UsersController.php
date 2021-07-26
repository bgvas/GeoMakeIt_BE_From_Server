<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Helpers\helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UsersController extends Controller
{
    /**
     * GET-RESPONSE (Get all users except admins)
     * @return string|array
     */
   public function GetAllUsers() {
        try{
            if(count($users = $users = DB::table('users')
            ->where('role_id', '<>', 1)
            ->get()
            ->toArray()) > 0) {
                return response()->json($users, 200);
            } else {
                return response()->json(['message' => 'no_users_found', 'displayed_message' => 'No users found'], 400);
            }
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General error.'], 400);
        }
   }


   /**
     * GET-RESPONSE (Get user by id)
     * @param $id
     * @return string | array
     */
    public function GetUserById($id) {

        try{
            if($user = User::whereId($id)->get()){
                return response()->json($user, 200);
            } else {
                return response()->json(['message' => 'user_not_found', 'displayed_message' => "User not found."], 400);
            }
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General error.'], 400);
        }
    }


    /**
     * Check if user is online or offline
     *
     * @return array
     */
  /*  public function isUserOnline()
    {

        $users = User::all();
        $userStatus = [];
        foreach ($users as $user) {
            if($user->role != 'super_admin'){
                if (Cache::has('user-is-online-' . $user->id)){
                    $userStatus[] = ['user' => $user, 'status' => 'online'];
                }
                else {
                    $userStatus[] = ['user' => $user, 'status' => 'offline'];
                }
            }
        }

        return $userStatus;
    }*/

    /**
     * Delete-user Http Request
     *
     * @param $userId
     * @return JsonResponse
     */
    public function DeleteUser($userId) {

        try{
            if(!Helper::checkUserById($userId)){
                return response()->json(['message' => 'user_not_found', 'displayed_message' => "User not found."], 400);
            }
            User::whereId($userId)->delete();
            return response()->json(['message' => 'user_deleted', 'displayed_message' => 'User deleted!'],200);

        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General error.'], 400);
        }
    }

    /**
     * Update-User PUT-Http request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateUser(Request $request, $id) {
        try{
            if(!Helper::checkUserById($id)){
                return response()->json(['message' => 'user_not_found', 'displayed_message' => "User not found."], 400);
            }
            User::whereId($id)->update($request[0]);

           return response()->json(['message' => 'user_updated', 'displayed_message' => 'User changes, saved successfully.'], 200);

        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General error.'], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function NewUser(Request $request) {

        try{
           $ar = $request[0];
           $ar['password'] = bcrypt($ar['password']);

           User::create($ar);

           return response()->json(['message' => 'user_created', 'displayed_message' => 'User created successfully'],200);

        } catch (Exception $ex){
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General error.'], 400);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function CheckIfUserNameExists(Request $request){
        try{
            return response()->json(['exists' => Helper::checkIfUserNameExists($request['username'])]);
        } catch (Exception $ex){
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General Error.'], 400);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function CheckIfEmailExists(Request $request){
        try{
            return response()->json(['exists' => Helper::checkIfEmailExists($request['email'])]);
        } catch (Exception $ex){
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => 'General Error.'], 400);
        }
    }
}
