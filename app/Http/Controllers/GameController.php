<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchGamesRequest;

class GameController extends Controller
{
    public function index(SearchGamesRequest $request)
    {
        $validated = $request->validated();

        $allGames = json_decode(file_get_contents(public_path() . "/games.json"), true);

        $games = [];

        $gameName = strtolower($request->get('gameName'));
        $gameMode = $request->get('gameMode');

        foreach ($allGames['games']['instant'] as $game) {
            if (strpos(strtolower($game['name']), $gameName) !== false) {
                array_push($games, $game);
            }
        }

        $results = 1;

        if ($results) {
            return response()->json([
                'gameList' => $games,
                'success'  => true
            ]);
        } else {
            return response()->json([
                'success'  => false
            ]);
        }
    }

    // TODO: make dynamic choice for play mode options
    public function getOptions(SearchGamesRequest $request)
    {

    }
}
