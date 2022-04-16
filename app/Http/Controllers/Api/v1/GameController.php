<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\SearchGamesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(SearchGamesRequest $request)
    {
        $validated = $request->validated();

        $allGames = json_decode(file_get_contents(public_path() . "/games.json"), true);

        $games = $allGames['games']['instant'];
        $results = [];

        $gameName = strtolower($request->get('gameName'));

        foreach ($games as $game) {
            if (strpos(strtolower($game['name']), $gameName) !== false) {
                array_push($results, $game);
            }
        }

        if ($games) {
            return response()->json([
                'gameList' => $results,
                'success'  => true
            ]);
        } else {
            return response()->json([
                'success'  => false
            ]);
        }
    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }
}
