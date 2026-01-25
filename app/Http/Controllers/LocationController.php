<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Prefecture;
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
        $location=Location::with('prefecture')->find($locationId);
        $surf_date = $request->input('surf_date', Carbon::today()->toDateString());
        $scoreQuery = Score::getLatestScores();
        if($surf_date){
            // 指定された日付から14日後までの範囲を取得
            $startDate = Carbon::parse($surf_date)->startOfDay();
            $endDate = Carbon::parse($surf_date)->addDays(13)->endOfDay();
            $scoreQuery->whereBetween("numt.datetime", [$startDate, $endDate]);
        }
        $scores = $scoreQuery->where('numt.location_id',$locationId)
            ->orderBy('numt.datetime', 'asc')
            ->get();

        $WaveArrowDegs = $scores->map(function($score){
            return ShorelineDirection::where('direction',$score->wave_direction)->value('arrow_deg');
        });

        $WindArrowDegs = $scores->map(function($score){
            return ShorelineDirection::where('direction',$score->wind_direction)->value('arrow_deg');
        });
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

        // 検索用のデータを取得
        $prefectures = Prefecture::orderBy('name')->get();
        $allLocations = Location::with('prefecture')->get();

        // パンくずリスト
        $breadcrumbs = [
            ['name' => 'TOP', 'url' => route('index')],
        ];
        if ($location && $location->prefecture) {
            $breadcrumbs[] = [
                'name' => $location->prefecture->name,
                'url' => '/prefectures?prefecture_id=' . $location->prefecture->id
            ];
        }
        if ($location) {
            $breadcrumbs[] = ['name' => $location->name, 'url' => null];
        }

        return view('surf_forecast.locations_test')->with([
            'location' => $location,
            'score' => $scores,
            'surfing_level' => $surfing_level->get(),
            'post' => $post->get(),
            'user' => $user->get(),
            'surf_date' => $surf_date,
            'shoreline_direction' => $shoreline_direction->get(),
            'wave_arrow_degs' => $WaveArrowDegs,
            'wind_arrow_degs' => $WindArrowDegs,
            'prefectures' => $prefectures,
            'allLocations' => $allLocations,
            'breadcrumbs' => $breadcrumbs,
            ]);
    }

    // AJAX用：都道府県に基づいてロケーションを取得
    public function getLocationsByPrefecture(Request $request)
    {
        $prefectureId = $request->input('prefecture_id');
        $locations = Location::where('prefecture_id', $prefectureId)
                            ->orderBy('name')
                            ->get();
        
        return response()->json($locations);
    }
}
