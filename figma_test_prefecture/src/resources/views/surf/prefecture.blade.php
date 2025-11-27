<x-app-layout>
    <x-slot name="header">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold">サーフスポット一覧</h2>
            <p class="text-muted-foreground">
                都道府県別のサーフィンスポットを探す
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- サイドバー -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- 都道府県選択 -->
                    <div class="bg-card text-card-foreground rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">都道府県選択</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="space-y-2">
                                <label for="prefecture-selector" class="block text-sm font-medium">都道府県を選択</label>
                                <select id="prefecture-selector" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    @foreach($prefectures as $region => $prefs)
                                        <optgroup label="{{ $region }}">
                                            @foreach($prefs as $pref)
                                                <option value="{{ $pref }}" {{ $pref === $selectedPrefecture ? 'selected' : '' }}>
                                                    {{ $pref }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 都道府県について -->
                    <div class="bg-card text-card-foreground rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight flex items-center gap-2">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="prefecture-title">{{ $selectedPrefecture }}</span>について
                            </h3>
                        </div>
                        <div class="p-6 pt-0">
                            <p id="prefecture-description" class="text-sm text-muted-foreground leading-relaxed">
                                {{ $prefectureDescription }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- メインコンテンツ -->
                <div class="lg:col-span-3">
                    <div id="spots-container" class="space-y-6">
                        @if(count($areas) === 0)
                            <div class="bg-card text-card-foreground rounded-lg border shadow-sm">
                                <div class="p-6 py-12">
                                    <div class="text-center text-muted-foreground">
                                        <svg class="h-12 w-12 mx-auto mb-4 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        <p>この都道府県にはサーフスポットが登録されていません</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($areas as $area)
                                <div class="space-y-4" data-area="{{ $area['name'] }}">
                                    <div class="flex items-center gap-3">
                                        <h2 class="text-2xl font-bold">{{ $area['name'] }}</h2>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground">
                                            {{ count($area['locations']) }}スポット
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($area['locations'] as $location)
                                            <div class="bg-card text-card-foreground rounded-lg border shadow-sm cursor-pointer hover:shadow-lg transition-shadow duration-200 hover:border-blue-500" 
                                                 onclick="window.location.href='/surf/spot/{{ $location['id'] }}'">
                                                <div class="flex flex-col space-y-1.5 p-6">
                                                    <h3 class="font-semibold leading-none tracking-tight text-lg flex items-center gap-2">
                                                        <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                                        </svg>
                                                        {{ $location['name'] }}
                                                    </h3>
                                                </div>
                                                <div class="p-6 pt-0 space-y-3">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="h-4 w-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        <span class="text-sm text-muted-foreground">{{ $area['name'] }}</span>
                                                    </div>
                                                    
                                                    <div class="space-y-2">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                            </svg>
                                                            <span class="text-sm font-medium">海岸の向き</span>
                                                        </div>
                                                        <div class="ml-6">
                                                            {!! createDirectionIndicator($location['shoreline_direction']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="pt-2">
                                                        <span class="inline-flex items-center rounded-md border border-input px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                                            詳細を見る →
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <footer class="text-center text-sm text-muted-foreground pt-8 border-t">
                <p>※ 各スポットをクリックすると詳細な波情報を確認できます。</p>
            </footer>
        </div>
    </div>

    @push('scripts')
    <script>
        // 都道府県データ
        const prefectureData = @json($allPrefectureData);
        
        // 都道府県選択の変更イベント
        document.getElementById('prefecture-selector').addEventListener('change', function() {
            const selectedPref = this.value;
            
            // ページを更新して新しい都道府県のデータを表示
            window.location.href = `/surf/prefecture?prefecture=${encodeURIComponent(selectedPref)}`;
        });

        // 方向インジケーターを作成する関数
        function createDirectionIndicator(direction) {
            const directionMap = {
                'N': 0, 'NE': 45, 'E': 90, 'SE': 135,
                'S': 180, 'SW': 225, 'W': 270, 'NW': 315
            };
            const rotation = directionMap[direction] || 0;
            
            const directionNames = {
                'N': '北', 'NE': '北東', 'E': '東', 'SE': '南東',
                'S': '南', 'SW': '南西', 'W': '西', 'NW': '北西'
            };
            
            return `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center relative bg-white">
                        <div class="absolute w-1.5 h-5 bg-blue-600 rounded-full transform origin-bottom" style="transform: rotate(${rotation}deg) translateY(-30%)"></div>
                        <div class="absolute w-2 h-2 bg-blue-600 rounded-full"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-medium text-sm">${direction}</span>
                        <span class="text-xs text-muted-foreground">${directionNames[direction]}</span>
                    </div>
                </div>
            `;
        }
    </script>
    @endpush
</x-app-layout>

@php
function createDirectionIndicator($direction) {
    $directionMap = [
        'N' => 0, 'NE' => 45, 'E' => 90, 'SE' => 135,
        'S' => 180, 'SW' => 225, 'W' => 270, 'NW' => 315
    ];
    $rotation = $directionMap[$direction] ?? 0;
    
    $directionNames = [
        'N' => '北', 'NE' => '北東', 'E' => '東', 'SE' => '南東',
        'S' => '南', 'SW' => '南西', 'W' => '西', 'NW' => '北西'
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
                <span class="text-xs text-muted-foreground">{$name}</span>
            </div>
        </div>
    HTML;
}
@endphp
