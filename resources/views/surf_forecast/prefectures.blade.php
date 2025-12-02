@extends('layouts.custom')

@section('content')
    <div class="py-6 pt-24">
        <div class="mx-auto max-w-7xl space-y-6 px-4 md:px-6">
            <div class="flex items-baseline justify-between">
                <h1 class="text-2xl md:text-3xl font-bold">
                {{ $prefecture->name }}のサーフィン・波情報
                </h1>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- サイドバー -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- 都道府県選択 -->
                    <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">都道府県選択</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="space-y-2">
                                <label for="prefecture-selector" class="block text-sm font-medium">都道府県を選択</label>
                                <select id="prefecture-selector" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="">都道府県を選択してください</option>
                                    @foreach($allPrefectures as $pref)
                                        <option value="{{ $pref->id }}" {{ $prefecture && $pref->id == $prefecture->id ? 'selected' : '' }}>
                                            {{ $pref->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 神奈川県のサーフィン事情について -->
                    @if($prefecture && $prefecture->name === '神奈川県（湘南・西湘）')
                    <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight flex items-center gap-2">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                神奈川県のサーフィン事情について
                            </h3>
                        </div>
                        <div class="p-6 pt-0">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $kanagawaDescription }}
                            </p>
                        </div>
                    </div>
                    @elseif($prefecture)
                    <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight flex items-center gap-2">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $prefecture->name }}</span>について
                            </h3>
                        </div>
                        <div class="p-6 pt-0">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $prefecture->name }}のサーフスポット一覧です。各スポットをクリックすると詳細な波情報を確認できます。
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- メインコンテンツ -->
                <div class="lg:col-span-3">
                    <div class="space-y-6">
                        @if($prefecture && count($locations) === 0)
                            <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                                <div class="p-6 py-12">
                                    <div class="text-center text-gray-600">
                                        <svg class="h-12 w-12 mx-auto mb-4 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        <p>この都道府県にはサーフスポットが登録されていません</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($prefecture)
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <h2 class="text-2xl font-bold">{{ $prefecture->name }}のサーフスポット</h2>
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-gray-100 text-gray-700">
                                        {{ count($locations) }}スポット
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($locations as $location)
                                        <div class="bg-white text-gray-900 rounded-lg border shadow-sm cursor-pointer hover:shadow-lg transition-shadow duration-200 hover:border-blue-500" 
                                             onclick="window.location.href='/locations/{{ $location->id }}'">
                                            <div class="flex flex-col space-y-1.5 p-6">
                                                <h3 class="font-semibold leading-none tracking-tight text-lg flex items-center gap-2">
                                                    {{ $location->name }}
                                                </h3>
                                                @if($location->city)
                                                <p class="text-sm text-gray-600">
                                                    {{ $location->city }}
                                                </p>
                                                @endif
                                            </div>
                                            <div class="p-6 pt-0 space-y-3">
                                                <!-- 今日の波高と風速 -->
                                                @if(isset($locationWaveData[$location->id]) && $locationWaveData[$location->id] !== null)
                                                @php
                                                    $data = $locationWaveData[$location->id];
                                                    $maxWaveHeight = $data['max_wave_height'];
                                                    $minWaveHeight = $data['min_wave_height'];
                                                    $maxWindSpeed = $data['max_wind_speed'];
                                                    $minWindSpeed = $data['min_wind_speed'];
                                                    
                                                    // 波高の色を計算（0~3mの範囲で#0f7fff ~ #ff781fのグラデーション）
                                                    $getWaveHeightColor = function($height) {
                                                        // 0m: #0f7fff (161, 214, 255)
                                                        // 3m: #ff550d (255, 120, 31)
                                                        $clampedHeight = max(0, min(3, $height));
                                                        $ratio = $clampedHeight / 3;
                                                        $r = round(161 + (255 - 161) * $ratio);
                                                        $g = round(214 + (120 - 214) * $ratio);
                                                        $b = round(255 + (31 - 255) * $ratio);
                                                        return "rgb({$r}, {$g}, {$b})";
                                                    };
                                                    
                                                    // 風速の色を計算（0~10m/sの範囲で#40b9ff ~ #ff781fのグラデーション）
                                                    $getWindSpeedColor = function($speed) {
                                                        // 0m/s: #0f7fff (161, 214, 255)
                                                        // 10m/s: #ff550d (255, 120, 31)
                                                        $clampedSpeed = max(0, min(10, $speed));
                                                        $ratio = $clampedSpeed / 10;
                                                        $r = round(161 + (255 - 161) * $ratio);
                                                        $g = round(214 + (120 - 214) * $ratio);
                                                        $b = round(255 + (31 - 255) * $ratio);
                                                        return "rgb({$r}, {$g}, {$b})";
                                                    };
                                                    
                                                    $maxWaveColor = $getWaveHeightColor($maxWaveHeight);
                                                    $minWaveColor = $getWaveHeightColor($minWaveHeight);
                                                    $maxWindColor = $getWindSpeedColor($maxWindSpeed);
                                                    $minWindColor = $getWindSpeedColor($minWindSpeed);
                                                @endphp
                                                <div class="space-y-3 pt-2">
                                                    <!-- 波高 -->
                                                    <div class="space-y-2">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                            </svg>
                                                            <span class="text-sm font-medium">今日の波高</span>
                                                        </div>
                                                        <div class="flex items-baseline gap-3">
                                                            <div>
                                                                <div class="text-xs text-gray-600 mb-1">最大</div>
                                                                <div class="text-2xl font-bold" style="color: {{ $maxWaveColor }};">
                                                                    {{ $maxWaveHeight }}m
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="text-xs text-gray-600 mb-1">最低</div>
                                                                <div class="text-2xl font-bold" style="color: {{ $minWaveColor }};">
                                                                    {{ $minWaveHeight }}m
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- 風速 -->
                                                    <div class="space-y-2">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="h-4 w-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                            </svg>
                                                            <span class="text-sm font-medium">今日の風速</span>
                                                        </div>
                                                        <div class="flex items-baseline gap-3">
                                                            <div>
                                                                <div class="text-xs text-gray-600 mb-1">最大</div>
                                                                <div class="text-2xl font-bold" style="color: {{ $maxWindColor }};">
                                                                    {{ $maxWindSpeed }}m/s
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="text-xs text-gray-600 mb-1">最低</div>
                                                                <div class="text-2xl font-bold" style="color: {{ $minWindColor }};">
                                                                    {{ $minWindSpeed }}m/s
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="pt-2">
                                                    <span class="inline-flex items-center rounded-md border border-gray-300 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                                        詳細を見る →
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                    @endforeach
                                </div>
                            </div>
                @endif
                    </div>
                </div>
            </div>

            <footer class="text-center text-sm text-gray-600 pt-8 border-t">
                <p>※ 各スポットをクリックすると詳細な波情報を確認できます。</p>
            </footer>
        </div>
    </div>

    @push('scripts')
    <script>
        // 都道府県選択の変更イベント
        document.getElementById('prefecture-selector').addEventListener('change', function() {
            const selectedPrefectureId = this.value;
            
            if (selectedPrefectureId) {
                // ページを更新して新しい都道府県のデータを表示
                window.location.href = `/prefectures?prefecture_id=${encodeURIComponent(selectedPrefectureId)}`;
            }
        });
    </script>
    @endpush
@endsection

@php
function createDirectionIndicator($direction) {
    $directionMap = [
        'N' => 0, 'NNE' => 23, 'NE' => 45, 'ENE' => 67,
        'E' => 90, 'ESE' => 113, 'SE' => 135, 'SSE' => 157,
        'S' => 180, 'SSW' => 203, 'SW' => 225, 'WSW' => 247,
        'W' => 270, 'WNW' => 293, 'NW' => 315, 'NNW' => 337
    ];
    $rotation = $directionMap[$direction] ?? 0;
    
    $directionNames = [
        'N' => '北', 'NNE' => '北北東', 'NE' => '北東', 'ENE' => '東北東',
        'E' => '東', 'ESE' => '東南東', 'SE' => '南東', 'SSE' => '南南東',
        'S' => '南', 'SSW' => '南南西', 'SW' => '南西', 'WSW' => '西南西',
        'W' => '西', 'WNW' => '西北西', 'NW' => '北西', 'NNW' => '北北西'
    ];
    $name = $directionNames[$direction] ?? '';
    
    return <<<HTML
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center relative bg-white">
                <div class="absolute w-1.5 h-5 bg-blue-600 rounded-full transform origin-bottom" style="transform: rotate({$rotation}deg) translateY(-30%)"></div>
                <div class="absolute w-2 h-2 bg-blue-600 rounded-full"></div>
            </div>
            <div class="flex flex-col">
                <span class="font-medium text-sm">{$direction}</span>
                <span class="text-xs text-gray-600">{$name}</span>
            </div>
        </div>
    HTML;
}
@endphp