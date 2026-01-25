<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Location;
use App\Models\Score;
use Carbon\Carbon;

class AreaController extends Controller
{
    public function prefecture(Request $request)
    {
        // リクエストから都道府県IDを取得、デフォルトは神奈川県（湘南・西湘）
        $prefectureId = $request->input('prefecture_id');
        
        if ($prefectureId) {
            $prefecture = Prefecture::find($prefectureId);
        } else {
            $prefecture = Prefecture::where('name', '神奈川県（湘南・西湘）')->first();
        }
        
        $locations = [];
        $locationWaveData = [];
        if ($prefecture) {
            $locations = Location::where('prefecture_id', $prefecture->id)->get();
            
            // 各locationの今日の波高データを取得
            $today = Carbon::today();
            $todayStart = $today->copy()->startOfDay();
            $todayEnd = $today->copy()->endOfDay();
            
            foreach ($locations as $location) {
                $scoreQuery = Score::getLatestScores();
                $scores = $scoreQuery->where('numt.location_id', $location->id)
                    ->whereBetween('numt.datetime', [$todayStart, $todayEnd])
                    ->orderBy('numt.datetime', 'asc')
                    ->get();
                
                // 今日の波高と風速の最大値・最小値を計算
                if ($scores->count() > 0) {
                    $locationWaveData[$location->id] = [
                        'max_wave_height' => round($scores->max('wave_height'), 1),
                        'min_wave_height' => round($scores->min('wave_height'), 1),
                        'max_wind_speed' => round($scores->max('wind_speed'), 1),
                        'min_wind_speed' => round($scores->min('wind_speed'), 1),
                    ];
                } else {
                    $locationWaveData[$location->id] = null;
                }
            }
        }
        
        // すべての都道府県リストを取得
        $allPrefectures = Prefecture::orderBy('name')->get();
        
        // 神奈川県のサーフィン事情説明文
        $kanagawaDescription = "神奈川県は、関東地方の南西部に位置する都道府県で、サーフィンに適した海岸が多く存在します。特に湘南エリアは日本を代表するサーフィンスポットとして知られており、一年を通して多くのサーファーが訪れます。相模湾に面した海岸線は、様々な波の条件に対応できる多様なスポットを提供しており、初心者から上級者まで楽しめる環境が整っています。";
        
        // パンくずリスト
        $breadcrumbs = [
            ['name' => 'TOP', 'url' => route('index')],
        ];
        if ($prefecture) {
            $breadcrumbs[] = ['name' => $prefecture->name, 'url' => null];
        }
        
        return view('surf_forecast.prefectures')->with([
            'prefecture' => $prefecture,
            'locations' => $locations,
            'allPrefectures' => $allPrefectures,
            'kanagawaDescription' => $kanagawaDescription,
            'locationWaveData' => $locationWaveData,
            'breadcrumbs' => $breadcrumbs
            ]);
    }
    public function index()
    {
        $allPrefectures = Prefecture::orderBy('name')->get();
        $defaultPrefecture = Prefecture::where('name', '神奈川県（湘南・西湘）')->first();
        $locations = collect();
        if ($defaultPrefecture) {
            $locations = Location::where('prefecture_id', $defaultPrefecture->id)->get();
        }

        return view('surf_forecast.index')->with([
            'allPrefectures' => $allPrefectures,
            'defaultPrefecture' => $defaultPrefecture,
            'locations' => $locations,
        ]);
    }
}
