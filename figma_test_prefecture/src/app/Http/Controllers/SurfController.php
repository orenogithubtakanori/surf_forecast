<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class SurfController extends Controller
{
    private $surfSpots = [
        [
            'id' => 'shonan',
            'name' => '湘南・茅ヶ崎',
            'location' => '神奈川県',
            'coast_direction' => 'S'
        ],
        [
            'id' => 'chiba',
            'name' => '九十九里浜',
            'location' => '千葉県',
            'coast_direction' => 'E'
        ],
        [
            'id' => 'shizuoka',
            'name' => '静波海岸',
            'location' => '静岡県',
            'coast_direction' => 'SE'
        ],
        [
            'id' => 'wakayama',
            'name' => '磯ノ浦',
            'location' => '和歌山県',
            'coast_direction' => 'W'
        ]
    ];

    // エリアデータ
    private $areas = [
        ['id' => 1, 'name' => '湘南', 'prefecture_name' => '神奈川県', 'region_name' => '関東'],
        ['id' => 2, 'name' => '九十九里', 'prefecture_name' => '千葉県', 'region_name' => '関東'],
        ['id' => 3, 'name' => '伊豆', 'prefecture_name' => '静岡県', 'region_name' => '東海'],
        ['id' => 4, 'name' => '紀伊', 'prefecture_name' => '和歌山県', 'region_name' => '関西'],
        ['id' => 5, 'name' => '外房', 'prefecture_name' => '千葉県', 'region_name' => '関東'],
    ];

    // ロケーションデータ
    private $locations = [
        ['id' => 1, 'area_id' => 1, 'name' => '鎌倉', 'shoreline_direction' => 'S'],
        ['id' => 2, 'area_id' => 1, 'name' => '藤沢', 'shoreline_direction' => 'S'],
        ['id' => 3, 'area_id' => 1, 'name' => '茅ヶ崎', 'shoreline_direction' => 'S'],
        ['id' => 4, 'area_id' => 1, 'name' => '平塚', 'shoreline_direction' => 'S'],
        ['id' => 5, 'area_id' => 1, 'name' => '湯河原', 'shoreline_direction' => 'SE'],
        ['id' => 6, 'area_id' => 2, 'name' => '片貝', 'shoreline_direction' => 'E'],
        ['id' => 7, 'area_id' => 2, 'name' => '一宮', 'shoreline_direction' => 'E'],
        ['id' => 8, 'area_id' => 5, 'name' => '太東', 'shoreline_direction' => 'E'],
        ['id' => 9, 'area_id' => 5, 'name' => '夷隅', 'shoreline_direction' => 'E'],
        ['id' => 10, 'area_id' => 3, 'name' => '静波海岸', 'shoreline_direction' => 'SE'],
        ['id' => 11, 'area_id' => 3, 'name' => '御前崎', 'shoreline_direction' => 'S'],
        ['id' => 12, 'area_id' => 4, 'name' => '磯ノ浦', 'shoreline_direction' => 'W'],
    ];

    public function index()
    {
        return view('surf.dashboard', [
            'surfSpots' => $this->surfSpots,
            'initialDate' => Carbon::now()->toDateString()
        ]);
    }

    public function getWaveData(Request $request)
    {
        $spotId = $request->input('spot_id', 'shonan');
        $date = $request->input('date', Carbon::now()->toDateString());

        $waveData = $this->generateMockData($spotId, $date);
        $sunsetTime = $this->getSunsetTime($spotId, $date);
        $spotInfo = $this->getSpotInfo($spotId);
        $selectedSpotData = collect($this->surfSpots)->firstWhere('id', $spotId);

        return response()->json([
            'wave_data' => $waveData,
            'sunset_time' => $sunsetTime,
            'spot_info' => $spotInfo,
            'selected_spot' => $selectedSpotData
        ]);
    }

    private function generateMockData($spotId, $date)
    {
        $baseWaveHeight = match ($spotId) {
            'shonan' => 1.2,
            'chiba' => 1.8,
            default => 1.5
        };

        $spotCharacteristics = [
            'shonan' => [
                'wave_directions' => ['S', 'SE', 'SW'],
                'wind_directions' => ['N', 'NE', 'E', 'W']
            ],
            'chiba' => [
                'wave_directions' => ['E', 'SE', 'NE'],
                'wind_directions' => ['W', 'NW', 'SW', 'N']
            ],
            'shizuoka' => [
                'wave_directions' => ['SE', 'S', 'E'],
                'wind_directions' => ['NW', 'N', 'NE', 'W']
            ],
            'wakayama' => [
                'wave_directions' => ['W', 'SW', 'NW'],
                'wind_directions' => ['E', 'SE', 'NE', 'S']
            ]
        ];

        $characteristics = $spotCharacteristics[$spotId] ?? $spotCharacteristics['shonan'];
        $data = [];

        for ($hour = 6; $hour <= 18; $hour++) {
            $variation = sin($hour / 24 * pi() * 2) * 0.5 + (mt_rand(-15, 15) / 100);
            $waveHeight = max(0.3, $baseWaveHeight + $variation);

            $waveDirection = $characteristics['wave_directions'][array_rand($characteristics['wave_directions'])];
            $windDirection = $characteristics['wind_directions'][array_rand($characteristics['wind_directions'])];

            $data[] = [
                'time' => sprintf('%02d:00', $hour),
                'wave_height' => round($waveHeight, 1),
                'wave_direction' => $waveDirection,
                'wind_speed' => round(3 + (mt_rand(0, 800) / 100), 1),
                'wind_direction' => $windDirection
            ];
        }

        return $data;
    }

    private function getSunsetTime($spotId, $date)
    {
        $sunsetTimes = [
            'shonan' => '17:42',
            'chiba' => '17:38',
            'shizuoka' => '17:45',
            'wakayama' => '17:51'
        ];

        return $sunsetTimes[$spotId] ?? '17:40';
    }

    private function getSpotInfo($spotId)
    {
        $spotInfo = [
            'shonan' => [
                'water_temp' => 16,
                'condition' => 'やや良好',
                'description' => '初心者から上級者まで楽しめる人気スポット'
            ],
            'chiba' => [
                'water_temp' => 15,
                'condition' => '良好',
                'description' => '安定した波質で練習に最適'
            ],
            'shizuoka' => [
                'water_temp' => 17,
                'condition' => '良好',
                'description' => '水質が良く景色も美しい'
            ],
            'wakayama' => [
                'water_temp' => 18,
                'condition' => 'かなり良好',
                'description' => '関西屈指のサーフポイント'
            ]
        ];

        return $spotInfo[$spotId] ?? [
            'water_temp' => 16,
            'condition' => 'やや良好',
            'description' => ''
        ];
    }

    public function getSurfSpots()
    {
        return response()->json($this->surfSpots);
    }

    // 都道府県一覧ページ
    public function prefecture(Request $request)
    {
        $selectedPrefecture = $request->input('prefecture', '神奈川県');
        
        // 都道府県リストを地域ごとにグループ化
        $prefectures = $this->getPrefecturesGrouped();
        
        // 選択された都道府県のエリアを取得
        $areasInPrefecture = collect($this->areas)
            ->where('prefecture_name', $selectedPrefecture)
            ->values()
            ->all();
        
        // エリアごとにロケーションをグループ化
        $areas = [];
        foreach ($areasInPrefecture as $area) {
            $locations = collect($this->locations)
                ->where('area_id', $area['id'])
                ->values()
                ->all();
            
            $areas[] = [
                'id' => $area['id'],
                'name' => $area['name'],
                'locations' => $locations
            ];
        }
        
        // 都道府県の説明文を取得
        $prefectureDescription = $this->getPrefectureDescription($selectedPrefecture);
        
        // すべての都道府県データ（JavaScript用）
        $allPrefectureData = $this->getAllPrefectureData();
        
        return view('surf.prefecture', [
            'prefectures' => $prefectures,
            'selectedPrefecture' => $selectedPrefecture,
            'areas' => $areas,
            'prefectureDescription' => $prefectureDescription,
            'allPrefectureData' => $allPrefectureData
        ]);
    }

    // 都道府県リストを地域ごとにグループ化
    private function getPrefecturesGrouped()
    {
        $grouped = [];
        foreach ($this->areas as $area) {
            $region = $area['region_name'];
            $prefecture = $area['prefecture_name'];
            
            if (!isset($grouped[$region])) {
                $grouped[$region] = [];
            }
            
            if (!in_array($prefecture, $grouped[$region])) {
                $grouped[$region][] = $prefecture;
            }
        }
        
        return $grouped;
    }

    // 都道府県の説明文を取得
    private function getPrefectureDescription($prefectureName)
    {
        $descriptions = [
            '神奈川県' => '神奈川県は日本を代表するサーフィンの聖地であり、湘南エリアを中心に数多くの優良なサーフスポットが点在しています。鎌倉、藤沢、茅ヶ崎、平塚など、それぞれ異なる波質と特徴を持つポイントがあり、初心者から上級者まで幅広いレベルのサーファーが楽しめる環境が整っています。都心からのアクセスが良好で、週末には多くのサーファーで賑わいます。湘南の海は南向きの海岸線が多く、南からのうねりをキャッチしやすいため、夏から秋にかけては安定した波が期待できます。また、江ノ島や富士山を望む美しい景観も魅力の一つです。',
            '千葉県' => '千葉県は九十九里浜と外房エリアを中心に、日本有数のサーフィンスポットが集まっています。太平洋に面した東向きの海岸線は、北東からのうねりを受けやすく、年間を通じて安定した波が立ちます。特に一宮、片貝、太東、夷隅などは国内外から多くのサーファーが訪れる人気スポットです。プロの大会も頻繁に開催され、ハイレベルなサーフィンを目にすることができます。波のパワーとサイズが湘南に比べて大きく、中級者以上のサーファーに特に人気があります。',
            '静岡県' => '静岡県の伊豆エリアは、透明度の高い海と美しい自然環境が特徴のサーフスポットです。御前崎や静波海岸など、南東から南向きの海岸線を持つポイントが多く、台風のうねりが入りやすい夏から秋にかけてがベストシーズンです。水温が比較的温かく、冬場でも快適にサーフィンを楽しむことができます。景観の美しさと波質の良さから、サーフトリップの目的地としても人気があります。',
            '和歌山県' => '和歌山県の紀伊エリアは関西屈指のサーフポイントとして知られており、磯ノ浦を中心に質の高い波が楽しめます。西向きの海岸線が特徴的で、西からのうねりを受けやすく、特に冬季には良質な波が立ちます。関西圏からのアクセスが良く、温暖な気候と美しい海岸線が魅力です。比較的混雑が少なく、落ち着いてサーフィンを楽しめる環境が整っています。',
        ];
        
        return $descriptions[$prefectureName] ?? 'この都道府県のサーフスポット情報をご覧いただけます。各スポットには独自の特徴があり、海岸の向きや波質によって最適な時期や条件が異なります。詳細な波情報は各スポットページでご確認ください。';
    }

    // すべての都道府県データを取得
    private function getAllPrefectureData()
    {
        $data = [];
        
        $prefectures = array_unique(array_column($this->areas, 'prefecture_name'));
        
        foreach ($prefectures as $prefecture) {
            $areasInPrefecture = collect($this->areas)
                ->where('prefecture_name', $prefecture)
                ->values()
                ->all();
            
            $areas = [];
            foreach ($areasInPrefecture as $area) {
                $locations = collect($this->locations)
                    ->where('area_id', $area['id'])
                    ->values()
                    ->all();
                
                $areas[] = [
                    'id' => $area['id'],
                    'name' => $area['name'],
                    'locations' => $locations
                ];
            }
            
            $data[$prefecture] = [
                'areas' => $areas,
                'description' => $this->getPrefectureDescription($prefecture)
            ];
        }
        
        return $data;
    }
}