<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Repositories\GameRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class GameController extends AppBaseController
{
    /** @var  GameRepository */
    private $gameRepository;

    public function __construct(GameRepository $gameRepo)
    {
        $this->gameRepository = $gameRepo;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Game.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $games = $this->gameRepository->all(
            ['user_id' => auth()->id()]
        );

        return view('studio.games.index')
            ->with('games', $games);
    }

    /**
     * Show the form for creating a new Game.
     *
     * @return Response
     */
    public function create()
    {
        return view('studio.games.create');
    }

    /**
     * Store a newly created Game in storage.
     *
     * @param CreateGameRequest $request
     *
     * @return Response
     */
    public function store(CreateGameRequest $request)
    {
        $input = $request->all();
        $input = array_merge($input, [
            'user_id' => Auth::user()->id,
        ]);
        $game = $this->gameRepository->create($input);

        Flash::success('Game saved successfully.');

        return redirect(route('studio.games.index'));
    }

    /**
     * Display the specified Game.
     *
     * @param Game $game
     * @return Response
     */
    public function show(Game $game)
    {
        if (empty($game)) {
            Flash::error('Game not found');

            return redirect(route('studio.games.index'));
        }

        if ($game->user_id != auth()->id()) {
            return redirect(route('studio.games.index'));
        }

        return view('studio.games.show')->with('game', $game);
    }

    /**
     * Show the form for editing the specified Game.
     *
     * @param Game $game
     * @return Response
     */
    public function edit(Game $game)
    {
        if (empty($game)) {
            Flash::error('Game not found');

            return redirect(route('studio.games.index'));
        }

        if ($game->user_id != auth()->id()) {
            return redirect(route('studio.games.index'));
        }

        return view('studio.games.edit')->with('game', $game);
    }

    /**
     * Update the specified Game in storage.
     *
     * @param int $id
     * @param UpdateGameRequest $request
     *
     * @return Response
     */
    public function update(Game $game, UpdateGameRequest $request)
    {
        if (empty($game)) {
            Flash::error('Game not found');

            return redirect(route('studio.games.index'));
        }

        if ($game->user_id != auth()->id()) {
            return redirect(route('studio.games.index'));
        }

        $game = $this->gameRepository->update($request->all(), $game->id);

        Flash::success('Game updated successfully.');

        return redirect(route('studio.games.index'));
    }

    /**
     * Remove the specified Game from storage.
     *
     * @param Game $game
     * @return Response
     * @throws \Exception
     */
    public function destroy(Game $game)
    {
        if (empty($game)) {
            Flash::error('Game not found');

            return redirect(route('studio.games.index'));
        }

        if ($game->user_id != auth()->id()) {
            return redirect(route('studio.games.index'));
        }

        $this->gameRepository->delete($game->id);

        Flash::success('Game deleted successfully.');

        return redirect(route('studio.games.index'));
    }
}
