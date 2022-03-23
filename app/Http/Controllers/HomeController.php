<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stadium;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result['totalGames'] = Game::get()->count();
        $result['events'] = $events = Event::get();
        $result['totalEvents'] = $events->count();
        $result['totalPlayers'] = Player::get()->count();
        $result['totalStadiums'] = Stadium::get()->count();

        return view(backView().'.dashboard')->with($result);
    }
}
