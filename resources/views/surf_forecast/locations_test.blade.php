@extends('layouts.custom')

@section('content')
    <div class="py-6 pt-24">
        <div class="mx-auto max-w-7xl space-y-6 px-4 md:px-6">
            <div class="flex items-baseline justify-between">
                <h1 class="text-2xl md:text-3xl font-bold">
                    {{ $location->name }}({{ $location->city}})の波情報
                </h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- サイドバー -->
                <div id="sidebar" class="md:col-span-1 space-y-4">
                    <!-- 検索条件 -->
                    <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">検索条件</h3>
                        </div>
                        <div class="p-6 pt-0 space-y-4">
                            <div class="space-y-2">
                                <label class="block">サーフスポット検索</label>
                                
                                <!-- 都道府県選択 -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium">都道府県</label>
                                    <select id="prefecture-selector" onchange="loadLocations()" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="">都道府県を選択してください</option>
                                        @foreach($prefectures as $prefecture)
                                            <option value="{{ $prefecture->id }}" {{ $prefecture->id == $location->prefecture_id ? 'selected' : '' }}>
                                                {{ $prefecture->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- サーフスポット選択 -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium">サーフスポット</label>
                                    <select id="location-selector" onchange="navigateToLocation(this.value)" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="">サーフスポットを選択してください</option>
                                        @foreach($allLocations as $loc)
                                            @if($loc->prefecture_id == $location->prefecture_id)
                                                <option value="{{ $loc->id }}" {{ $loc->id == $location->id ? 'selected' : '' }}>
                                                    {{ $loc->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <div class="space-y-2">
                                <label class="block">日付</label>
                                <div class="flex items-center gap-1">
                                    <button id="prev-day" class="inline-flex items-center justify-center whitespace-nowrap rounded-md border border-gray-300 bg-white hover:bg-gray-50 h-9 px-2">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <div class="flex-1">
                                        <input id="date-selector" type="date" value="{{ $surf_date }}" class="h-10 w-full rounded-md border border-gray-300 bg-white px-1 py-2 text-sm md:text-base text-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" style="text-align: center;">
                                    </div>
                                    <button id="next-day" class="inline-flex items-center justify-center whitespace-nowrap rounded-md border border-gray-300 bg-white hover:bg-gray-50 h-9 px-2">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                                <p id="date-display" class="text-sm text-muted-foreground"></p>
                            </div>
                        </div>
                    </div>

                    <!-- スポット情報 -->
                    <div id="spot-info-card" class="bg-white text-gray-900 rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight flex items-center gap-2">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                スポット情報
                            </h3>
                        </div>
                        <div class="p-6 pt-0 space-y-4">
                            <div>
                                <p id="spot-name" class="font-semibold">{{ $location->name }}</p>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium">海岸の向き:</span>
                                    <div id="spot-location" class="text-sm">
                                        @php
                                            $coastDirObj = ($shoreline_direction ?? collect())->firstWhere('id', $location->shoreline_direction_id);
                                            $coastDirCode = $coastDirObj->direction ?? null;
                                            
                                            // 16方位 -> 日本語変換
                                            $dirJaMap = [
                                                'N' => '北','NNE' => '北北東','NE' => '北東','ENE' => '東北東',
                                                'E' => '東','ESE' => '東南東','SE' => '南東','SSE' => '南南東',
                                                'S' => '南','SSW' => '南南西','SW' => '南西','WSW' => '西南西',
                                                'W' => '西','WNW' => '西北西','NW' => '北西','NNW' => '北北西'
                                            ];
                                            
                                            $coastDirJa = $dirJaMap[$coastDirCode] ?? $coastDirCode;
                                        @endphp
                                        {{ $coastDirJa }}
                                    </div>
                                    <div id="coast-direction" >
                                        @php
                                            $coastDirObj = ($shoreline_direction ?? collect())->firstWhere('id', $location->shoreline_direction_id);
                                            $coastAngle = $coastDirObj->arrow_deg ?? 0;
                                        @endphp
                                         <div class="w-6 h-6 flex items-center justify-center">
                                             <div class="text-black text-lg font-bold transform" style="transform: rotate({{$coastAngle}}deg)">↑</div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- メインコンテンツ -->
                <div class="md:col-span-3 space-y-6">
                    <div id="loading" class="text-center py-8">
                        <p>データを読み込み中...</p>
                    </div>

                    <!-- チャート -->
                    <div id="chart-container" class="bg-white text-gray-900 rounded-lg border shadow-sm" style="display: none;">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">14日間の波予報概況</h3>
                        </div>
                        <div class="p-6 pt-0 space-y-6">
                            <!-- 波高チャート -->
                            <div>
                                <h4 class="font-medium text-sm text-gray-600 mb-2">波高</h4>
                                <div class="h-48">
                                    <canvas id="waveChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- データテーブル -->
                    <div id="table-container" class="bg-white text-gray-900 rounded-lg border shadow-sm" style="display: none;">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">1時間ごとの波情報</h3>
                </div>
                        <div style="padding: 10px;">
                            <div class="relative w-full overflow-auto">
                @php
                    // 海岸の向き情報
                    $coastDirObj = ($shoreline_direction ?? collect())->firstWhere('id', $location->shoreline_direction_id);
                    $coast_dir_code = $coastDirObj->direction ?? null;
                    $coast_deg = $coastDirObj->arrow_deg ?? null;

                    // 16方位 -> 日本語
                    $dirJa = [
                        'N' => '北','NNE' => '北北東','NE' => '北東','ENE' => '東北東',
                        'E' => '東','ESE' => '東南東','SE' => '南東','SSE' => '南南東',
                        'S' => '南','SSW' => '南南西','SW' => '南西','WSW' => '西南西',
                        'W' => '西','WNW' => '西北西','NW' => '北西','NNW' => '北北西'
                    ];

                    // 角度差からオン/サイド/オフを判定
                    $judgeCondition = function (?float $windDeg, ?float $coastDeg) {
                        if ($windDeg === null || $coastDeg === null) return null;
                        $diff = abs($windDeg - $coastDeg);
                        if ($diff > 180) $diff = 360 - $diff;
                        if ($diff <= 22.5) return 'オン';
                        if ($diff <= 67.5) return 'サイドオン';
                        if ($diff < 112.5) return 'サイド';
                        if ($diff <= 157.5) return 'サイドオフ';
                        return 'オフ';
                    };
                @endphp

                                <table id="wave-table" class="w-full caption-bottom text-xs md:text-sm" style="table-layout: fixed;">
                                    <!-- テーブルヘッダー部分 -->
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 text-center align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0" style="width: 80px; min-width: 80px; padding: 5px;">時刻</th>
                                            <th class="h-12 text-center align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0" style="width: 80px; min-width: 80px; padding: 5px;">波高・波向</th>
                                            <th class="h-12 text-center align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0" style="width: 80px; min-width: 80px; padding: 5px;">風速・風向</th>
                                            <th class="h-12 text-center align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0" style="width: 80px; min-width: 80px; padding: 5px;">オフorオン</th>
                        </tr>
                    </thead>
                                    <!-- テーブルデータ部分 -->
                                    <tbody id="table-body" class="[&_tr:last-child]:border-0">
                    @php
                        $prevDate = null;
                    @endphp
                    @foreach($score as $index => $s)
                        @if($s->location_id === $location->id)
                                                @php
                                                    $currentDate = \Carbon\Carbon::parse($s->datetime)->format('Y-m-d');
                                                    $isNewDay = $prevDate !== null && $prevDate !== $currentDate;
                                                    $prevDate = $currentDate;
                                                    $borderStyle = $isNewDay ? 'border-top: 3px solid #6b7280;' : '';
                                                @endphp
                                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" style="{{ $borderStyle }}">
                                                    <td class="align-middle text-center" style="width: 80px; min-width: 80px; padding: 5px;">{{\Carbon\Carbon::parse($s->datetime)->format('n/j H時')}}</td>
                                                    
                                                    <!-- 波高・波向を同じカラムに縦に表示 -->
                                                    <td class="align-middle text-center" style="width: 80px; min-width: 80px; padding: 5px;">
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div>{{$s->wave_height}}m</div>
                                                            <div class="flex items-center gap-1">
                                                                @php
                                                                    $waveDir = $s->wave_direction;
                                                                    $waveAngle = match($waveDir) {
                                                                        'N' => 0, 'NNE' => 22.5, 'NE' => 45, 'ENE' => 67.5,
                                                                        'E' => 90, 'ESE' => 112.5, 'SE' => 135, 'SSE' => 157.5,
                                                                        'S' => 180, 'SSW' => 202.5, 'SW' => 225, 'WSW' => 247.5,
                                                                        'W' => 270, 'WNW' => 292.5, 'NW' => 315, 'NNW' => 337.5,
                                                                        default => 0
                                                                    };
                                                                @endphp
                                                                <div class="w-5 h-5 flex items-center justify-center">
                                                                    <div class="text-blue-600 text-base font-bold transform" style="transform: rotate({{$waveAngle + 180}}deg)">↑</div>
                                                                </div>
                                                                <span style="font-size: 12px !important;">{{ $dirJa[$s->wave_direction] ?? $s->wave_direction }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <!-- 風速・風向を同じカラムに縦に表示 -->
                                                    <td class="align-middle text-center" style="width: 80px; min-width: 80px; padding: 5px;">
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div>{{$s->wind_speed}}m/s</div>
                                                            <div class="flex items-center gap-1">
                                                                @php
                                                                    $windDir = $s->wind_direction;
                                                                    $windAngle = match($windDir) {
                                                                        'N' => 0, 'NNE' => 22.5, 'NE' => 45, 'ENE' => 67.5,
                                                                        'E' => 90, 'ESE' => 112.5, 'SE' => 135, 'SSE' => 157.5,
                                                                        'S' => 180, 'SSW' => 202.5, 'SW' => 225, 'WSW' => 247.5,
                                                                        'W' => 270, 'WNW' => 292.5, 'NW' => 315, 'NNW' => 337.5,
                                                                        default => 0
                                                                    };
                                                                @endphp
                                                                <div class="w-5 h-5 flex items-center justify-center">
                                                                    <div class="text-green-600 text-base font-bold transform" style="transform: rotate({{$windAngle + 180}}deg)">↑</div>
                                                                </div>
                                                                <span style="font-size: 12px !important;">{{ $dirJa[$s->wind_direction] ?? $s->wind_direction }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <!-- 評価 -->
                                                    <td class="align-middle text-center" style="width: 80px; min-width: 80px; padding: 5px;">
                                                        <div class="condition-tag-container" style="display: flex; justify-content: center; align-items: center;">
                                                            @php
                                                                $cond = $judgeCondition($windAngle, $coast_deg);
                                                                $condClass = match($cond){
                                                                    'オン' => 'text-white border-transparent',
                                                                    'オフ' => 'text-white border-transparent',
                                                                    'サイドオン' => 'text-white border-transparent',
                                                                    'サイドオフ' => 'text-white border-transparent',
                                                                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                                                                };
                                                                $condStyle = match($cond){
                                                                    'オン' => 'width: 80px; min-width: 80px; max-width: 80px; flex: none; flex-shrink: 0; text-align: center; display: flex; align-items: center; justify-content: center; background-color: #EEA23E',
                                                                    'オフ' => 'width: 80px; min-width: 80px; max-width: 80px; flex: none; flex-shrink: 0; text-align: center; display: flex; align-items: center; justify-content: center; background-color: #A1E1A7',
                                                                    'サイドオン' => 'width: 80px; min-width: 80px; max-width: 80px; flex: none; flex-shrink: 0; text-align: center; display: flex; align-items: center; justify-content: center; background-color: #F3BA6E',
                                                                    'サイドオフ' => 'width: 80px; min-width: 80px; max-width: 80px; flex: none; flex-shrink: 0; text-align: center; display: flex; align-items: center; justify-content: center; background-color: #C8EDCB',
                                                                    default => 'width: 80px; min-width: 80px; max-width: 80px; flex: none; flex-shrink: 0; text-align: center; display: flex; align-items: center; justify-content: center;'
                                                                };
                                                            @endphp
                                                            @if($cond)
                                                                <span class="condition-tag inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold border {{$condClass}}" style="{{$condStyle}}">{{ $cond }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                            </tr>    
                        @endif
                    @endforeach
                    </tbody>
                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="text-center text-sm text-muted-foreground pt-8 border-t">
                <p>※ これはデモデータです。実際の波情報ではありません。</p>
            </footer>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let waveChart;
        let currentData = [];
        let sharedHoverIndex = null;

        // ハイライトカード自体をCSSのstickyで固定（md以上、top-6）

        // 初期化
        document.addEventListener('DOMContentLoaded', function() {
            updateDateDisplay();
            updateCharts();
            
            // イベントリスナー
            document.getElementById('date-selector').addEventListener('change', function() {
                updateDateDisplay();
                navigateToSelectedDate();
            });
            document.getElementById('prev-day').addEventListener('click', changeDateBy(-1));
            document.getElementById('next-day').addEventListener('click', changeDateBy(1));
        });

        function updateDateDisplay() {
            const dateInput = document.getElementById('date-selector');
            const dateDisplay = document.getElementById('date-display');
            const date = new Date(dateInput.value);
            dateDisplay.textContent = date.toLocaleDateString('ja-JP', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            });
        }

        function changeDateBy(days) {
            return function() {
                const dateInput = document.getElementById('date-selector');
                const currentDate = new Date(dateInput.value);
                currentDate.setDate(currentDate.getDate() + days);
                dateInput.value = currentDate.toISOString().split('T')[0];
                updateDateDisplay();
                navigateToSelectedDate();
            };
        }

        function navigateToSelectedDate(){
            const dateInput = document.getElementById('date-selector');
            const url = new URL(window.location.href);
            url.searchParams.set('surf_date', dateInput.value);
            // 保持されている他のクエリは維持して遷移
            window.location.href = url.toString();
        }



        // 方角を日本語に変換する関数（16方位対応）
        function getJapaneseDirection(direction) {
            const directionMap = {
                'N': '北', 'NNE': '北北東', 'NE': '北東', 'ENE': '東北東',
                'E': '東', 'ESE': '東南東', 'SE': '南東', 'SSE': '南南東',
                'S': '南', 'SSW': '南南西', 'SW': '南西', 'WSW': '西南西',
                'W': '西', 'WNW': '西北西', 'NW': '北西', 'NNW': '北北西'
            };
            return directionMap[direction] || direction;
        }

        function updateCharts() {
            const waveData = @json($score->where('location_id', $location->id)->values());
            
            if (waveData.length === 0) return;
            
            // 日付ごとにデータをグループ化
            const dailyData = {};
            waveData.forEach(d => {
                const date = new Date(d.datetime);
                const dateKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                
                if (!dailyData[dateKey]) {
                    dailyData[dateKey] = {
                        date: date,
                        waveHeights: [],
                        waveDirections: []
                    };
                }
                
                dailyData[dateKey].waveHeights.push(parseFloat(d.wave_height));
                dailyData[dateKey].waveDirections.push(d.wave_direction);
            });
            
            // 日付順にソート
            const sortedDates = Object.keys(dailyData).sort();
            
            // 1日の平均値を計算
            const labels = sortedDates.map(dateKey => {
                const date = dailyData[dateKey].date;
                const month = date.getMonth() + 1;
                const day = date.getDate();
                return `${month}/${day}`;
            });
            
            const waveHeights = sortedDates.map(dateKey => {
                const heights = dailyData[dateKey].waveHeights;
                return heights.reduce((sum, h) => sum + h, 0) / heights.length;
            });
            
            // 波向は最頻値を使用（簡易的に最初の値を使用）
            const waveDirections = sortedDates.map(dateKey => dailyData[dateKey].waveDirections[0]);

            // 波高チャート
            const waveCtx = document.getElementById('waveChart').getContext('2d');
            if (waveChart) waveChart.destroy();
            waveChart = new Chart(waveCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '波高 (m)',
                        data: waveHeights,
                        backgroundColor: (ctx) => {
                            const index = ctx.dataIndex;
                            return sharedHoverIndex === index ? 'rgba(14, 165, 233, 0.8)' : 'rgba(14, 165, 233, 0.6)';
                        },
                        borderColor: '#0ea5e9',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterBody: function(context) {
                                    const index = context[0].dataIndex;
                                    return `波向: ${getJapaneseDirection(waveDirections[index])}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 3,
                            title: {
                                display: true,
                                text: '波高 (m)'
                            }
                        }
                    },
                    onHover: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            if (sharedHoverIndex !== index) {
                                sharedHoverIndex = index;
                                updateWaveChartHighlight();
                            }
                        } else {
                            if (sharedHoverIndex !== null) {
                                sharedHoverIndex = null;
                                updateWaveChartHighlight();
                            }
                        }
                    }
                }
            });
        }


        function updateWaveChartHighlight() {
            if (waveChart) {
                waveChart.update('none');
            }
        }

        // 都道府県選択時にサーフスポットを読み込み
        function loadLocations() {
            const prefectureId = document.getElementById('prefecture-selector').value;
            const locationSelector = document.getElementById('location-selector');
            
            // サーフスポットをリセット
            locationSelector.innerHTML = '<option value="">サーフスポットを選択してください</option>';
            locationSelector.disabled = false;
            
            if (prefectureId) {
                fetch(`/api/locations-by-prefecture?prefecture_id=${prefectureId}`)
                    .then(response => response.json())
                    .then(locations => {
                        locationSelector.innerHTML = '<option value="">サーフスポットを選択してください</option>';
                        locations.forEach(location => {
                            const option = document.createElement('option');
                            option.value = location.id;
                            option.textContent = location.name;
                            locationSelector.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading locations:', error));
            }
        }

        // サーフスポット選択時のページ遷移
        function navigateToLocation(locationId) {
            if (locationId && locationId !== '{{ $location->id }}') {
                const currentUrl = new URL(window.location.href);
                const newUrl = currentUrl.pathname.replace(/\/\d+$/, '/' + locationId);
                window.location.href = newUrl;
            }
        }

        // 初期表示
        document.getElementById('loading').style.display = 'none';
        document.getElementById('chart-container').style.display = 'block';
        document.getElementById('table-container').style.display = 'block';
    </script>
    @endpush
@endsection