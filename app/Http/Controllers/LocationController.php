<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Surfing_Level;
use App\Models\ShorelineDirection;
use App\Models\Score;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class LocationController extends Controller
{
    public function location(Location $location,Score $score,Surfing_Level $surfing_level,ShorelineDirection $shoreline_direction,Post $post,User $user,Request $request,$locationId)
    {
        $location=Location::find($locationId);
        $surf_date = $request->input('surf_date', Carbon::today()->toDateString());
        $scoreQuery = Score::getLatestScores();
        if($surf_date){
            $scoreQuery->where("numt.datetime","like","{$surf_date}%");
        }
        $scores = $scoreQuery->where('numt.location_id',$locationId)->get();
        /*
        DB::select(
            DB::raw("
            select
                *
            from(
                select
                    *,
                    row_number() over(partition by datetime,location_id order by created_at desc) as num
                from
                    scores
                ) as subquery
            where
                num = 1
                and
                datetime like '{{$surf_date}}%'
        "));
        */

        return view('surf_forecast.locations_test')->with([
            'location' => $location,
            'score' => $scores,
            'surfing_level' => $surfing_level->get(),
            'post' => $post->get(),
            'user' => $user->get(),
            'surf_date' => $surf_date,
            'shoreline_direction' => $shoreline_direction->get(),
            ]);
    }
}
