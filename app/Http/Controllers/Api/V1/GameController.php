<?php

namespace App\Http\Controllers\Api\V1;

use App\helpers\Helper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Get-Request (get all games of a specific user)
     *
     * @param $userId
     * @return JsonResponse
     */
    public function GetAllGamesByUserId($userId) {

        try{
            if(count($games = DB::table('games')->get()->where('user_id', '=', $userId)->toArray()) > 0){
                return response()->json(['games' => $games],200);
            } else {
                return response()->json(['message' => 'games_not_found', 'displayed_message' => 'There are no games for this user'], 400);
            }
        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }

    }

    /**
     * Get-Request (get game by id)
     *
     * @param $id
     * @return JsonResponse
     */
    public function GetGameById($id) {
        try{
            if($game = DB::table('games')->get()
                ->where('id','=', $id)
                ->first()){
                return response()->json(['game' => $game],200);
            } else {
                return response()->json(['message' => 'game_not_found', 'displayed_message' => 'Game not found'], 400);
            }

        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }
    }


    /**
     * Get-Request(all games from all users)
     *
     * @return JsonResponse
     *
     */
    public function GetAllGames() {
        try{
            if(count($games = DB::table('games')->get()->toArray()) > 0){
                return response()->json(['games' => $games],200);
            } else {
                return response()->json(['message' => 'games_not_found', 'displayed_message' => 'No games found'], 400);
            }
        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }
    }


    /**
     * Post-Request (create a new game for a specific user)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function NewGameForUser(Request $request) {

        try{
            $newGame = $request[0];
            if($newGame == null){
                return response()->json(['message' => 'no_game_data', 'displayed_message' => 'Game without data'], 400);
            }

            if(!Helper::checkUserById($newGame['userId'])) {
                return response()->json(['message' => 'user_not_found', 'displayed_message' => "User not found."], 400);
            }

            $newGame['created_at'] = Carbon::now();

            if(DB::table('user_game')->insert([$newGame])){
                return response()->json(['message' => 'game_created'], 200);
            } else {
                return response()->json(['message' => 'game_creation_error', 'displayed_message' => 'Error while creating the game'], 400);
            }
        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }


    }

    /**
     * Put-Request (Update game)
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function UpdateGame(Request $request, $id) {

        try{
            if(!Helper::checkGameById($id)) {
                return response()->json(['message' => 'game_not_found', 'displayed_message' => "Game not found."], 400);
            }

            $game = $request[0];

            if(!DB::table('user_game')->get()->where('id', '=', $id)->first()){
                return response()->json(['message' => 'game_not_found', 'displayed_message' => 'Game not found'], 400);
            }

            $game['updated_at'] = Carbon::now();

            if(DB::table('user_game')->where('id', '=', $id)->update($game)){
                return response()->json(['message' => 'game_updated', 'displayed_message' => 'Game updated successfully'], 200);
            } else {
                return response()->json(['message' => 'game_not_updated', 'displayed_message' => 'Error while updating game'], 400);
            }
        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }
    }

    /**
     * Delete Request(Delete game)
     *
     * @param $id
     * @return JsonResponse
     */
    public function DeleteGame($id) {
        try{
            if(!Helper::checkGameById($id)) {
                return response()->json(['message' => 'game_not_found', 'displayed_message' => "Game not found."], 400);
            }

            if(DB::table('user_game')->delete($id)){
                return response()->json(['message' => 'game_deleted', 'displayed_message' => 'Game deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'game_not_deleted', 'displayed_message' => 'Error while deleting game'], 400);
            }
        } catch(Exception $ex) {
            return response()->json(['message' => $ex->getMessage(), 'displayed_message' => "General error."], 400);
        }

    }
}
