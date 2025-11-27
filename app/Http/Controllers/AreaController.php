<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Location;

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
        if ($prefecture) {
            $locations = Location::where('prefecture_id', $prefecture->id)->get();
        }
        
        // すべての都道府県リストを取得
        $allPrefectures = Prefecture::orderBy('name')->get();
        
        // 神奈川県のサーフィン事情説明文
        $kanagawaDescription = "神奈川県は、関東地方の南西部に位置する都道府県で、サーフィンに適した海岸が多く存在します。特に湘南エリアは日本を代表するサーフィンスポットとして知られており、一年を通して多くのサーファーが訪れます。相模湾に面した海岸線は、様々な波の条件に対応できる多様なスポットを提供しており、初心者から上級者まで楽しめる環境が整っています。";
        
        return view('surf_forecast.prefectures')->with([
            'prefecture' => $prefecture,
            'locations' => $locations,
            'allPrefectures' => $allPrefectures,
            'kanagawaDescription' => $kanagawaDescription
            ]);
    }
    public function index()
    {
        return view('surf_forecast/index');
    }
}
