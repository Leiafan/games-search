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

        $gamesData = json_decode(file_get_contents(public_path() . "/games.json"), true);

        list (
            $games,
            $categories,
            $results,
            ) = [
            $gamesData['games']['instant'],
            $gamesData['categories']['mainCategories'],
            [],
        ];

        $gameName = strtolower($request->get('gameName'));

        foreach ($games as $game) {
            if (strpos(strtolower($game['name']), $gameName) !== false) {
                array_push($results, $game);
            }
        }

        // TODO: optimize structure
        for ($num = 0; $num < count($results); $num++) {
            foreach ($categories as $category) {
                foreach ($category['subCategories'] as $subCategory) {
                    if (in_array($results[$num]['id'], $subCategory['instantGamesOrder'])) {
                        $results[$num]['subCategory'] = $subCategory['name'];
                        $results[$num]['mainCategory'] = $category['name'];
                        continue;
                    }
                }
            }
        }

        usort($results, function ($a, $b) {
           return $b['mainCategory'] <=> $a['mainCategory'];
        });

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
