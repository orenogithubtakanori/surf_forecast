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
        return view('surf_forecast.locations')->with([
            'location' => $location,
            'score' => $score->whereBetween(DB::raw("SUBSTRING(datetime, 12, 10)"), ['06:00:00', '18:00:00'])->get(),
            'surfing_level' => $surfing_level->get(),
            'post' => $post->get(),
            'user' => $user->get(),
            ]);
    }
}
