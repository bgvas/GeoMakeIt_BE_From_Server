<?php

namespace App\Http\Controllers\Games;

use App\Jobs\AssembleGame;
use App\Models\Game;
use App\Http\Controllers\Controller;
use Flash;
use Illuminate\Support\Facades\Session;

class BuilderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Game's Plugins (for edit).
     *
     * @param Game $game
     * @return Response
     */
    public function index(Game $game)
    {
        return view('studio.games.builder.index',
        [
            'game' => $game,
        ]);
    }

    public function build(Game $game)
    {
        if($game->status == "building"){
            Flash::error("{$game->title} is already building. You'll be notified when it's ready.");
            return redirect()->route('studio.games.builder.index', ['game'=>$game]);
        }
        $game->status = "building";
        $game->save();
        AssembleGame::dispatch($game);

        $extra_scripts = <<<EOD
                <script>
                    $(function() {
                        Swal.fire({
                            icon: 'success',
                            iconHtml: '<i class="fas fa-hammer"><i/>',
                            title: 'Your build started',
                            html: 'We have just started building {$game->title}. This process takes usually takes about <strong>1-5 minutes</strong>. You\'ll be notified when the build process is complete.',
                            confirmButtonText: 'Awesome! <i class="fas fa-glass-cheers"></i>',
                        });
                    });
                </script>
EOD;
        Session::flash('extra_scripts', $extra_scripts);
        return redirect()->route('studio.games.builder.index', ['game'=>$game,]);
    }

    public function download(Game $game)
    {
        if($game->release_file == null || $game->status != "release") {
            Flash::error("{$game->title} has not yet been built!");
            return redirect()->route('studio.games.builder.index', ['game'=>$game]);
        }

        Flash::success("Download of game {$game->title} will start soon");
        return $game->download_release();
    }
}
