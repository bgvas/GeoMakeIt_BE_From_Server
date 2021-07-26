<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\User;

class helper {

    public static function checkUserById($id) {
        return User::whereId($id)->Exists();
    }

    public static function checkGameById($id) {
        return DB::table('games')->where('id', '=', $id)->Exists();
    }

    public static function checkPluginById($id) {
        return DB::table('plugins')->where('id', '=', $id)->Exists();
    }

    public static function checkIfUserNameExists($username) {
        return User::whereUsername($username)->exists();
    }

    public static function checkIfEmailExists($email) {
        return User::whereEmail($email)->exists();
    }
}
