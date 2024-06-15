<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Surfing_Level;
use App\Models\Score;
use App\Models\Post;
use App\Models\User;

class LocationController extends Controller
{
    public function location(Location $location,Score $score,Surfing_Level $surfing_level,Post $post,User $user)
    {
        return view('surf_forecast.locations_test')->with([
            'location' => $location,
            'score' => $score->getLatestScores(),
            'surfing_level' => $surfing_level->get(),
            'post' => $post->get(),
            'user' => $user->get(),
            ]);
    }
}
