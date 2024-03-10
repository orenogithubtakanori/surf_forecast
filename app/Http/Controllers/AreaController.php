<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Location;

class AreaController extends Controller
{
    public function prefecture(Area $area)
    {
        return view('surf_forecast.prefectures')->with([
            'area' => $area->get()
            ]);
    }
    public function area(Area $area,Location $location)
    {
        return view('surf_forecast.areas')->with([
            'area' => $area,
            'location' => $location->get()
            ]);
    }
    public function index()
    {
        return view('surf_forecast/index');
    }
}
