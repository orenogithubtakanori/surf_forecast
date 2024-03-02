<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Surfing_Level;
use App\Models\Score;

class LocationController extends Controller
{
    public function location(Location $location,Score $score,Surfing_Level $surfing_level)
    {
        return view('surf_forecast.locations')->with([
            'location' => $location,
            'score' => $score->get(),
            'surfing_level' => $surfing_level->get()
            ]);
    }
}
