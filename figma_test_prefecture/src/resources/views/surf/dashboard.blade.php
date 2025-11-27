<x-app-layout>
    <x-slot name="header">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold">サーフィンスポット波情報</h2>
            <p class="text-muted-foreground">
                リアルタイムの波高・風速情報で最適なサーフィンタイムを見つけよう
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- サイドバー -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- 検索条件 -->
                    <div class="bg-card text-card-foreground rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">検索条件</h3>
                        </div>
                        <div class="p-6 pt-0 space-y-4">
                            <div class="space-y-2">
                                <label class="block">サーフスポット</label>
                                <select id="spot-selector" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    @foreach($surfSpots as $spot)
                                        <option value="{{ $spot['id'] }}" {{ $spot['id'] == 'shonan' ? 'selected' : '' }}>
                                            {{ $spot['name'] }} - {{ $spot['location'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block">日付</label>
                                <div class="flex items-center gap-2">
                                    <button id="prev-day" class="inline-flex items-center justify-center whitespace-nowrap rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <div class="flex-1 relative">
                                        <input id="date-selector" type="date" value="{{ $initialDate }}" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <button id="next-day" class="inline-flex items-center justify-center whitespace-nowrap rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
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
                    <div id="spot-info-card" class="bg-card text-card-foreground rounded-lg border shadow-sm">
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
                                <p id="spot-name" class="font-semibold"></p>
                                <p id="spot-location" class="text-sm text-muted-foreground"></p>
                                <p id="spot-description" class="text-sm mt-1"></p>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span class="text-sm font-medium">海岸の向き:</span>
                                </div>
                                <div id="coast-direction" class="ml-6"></div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span id="water-temp" class="text-sm"></span>
                            </div>
                            
                            <div>
                                <span id="condition-badge" class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"></span>
                            </div>
                        </div>
                    </div>

                    <!-- 今日のハイライト -->
                    <div class="bg-card text-card-foreground rounded-lg border shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">今日のハイライト</h3>
                        </div>
                        <div id="highlights" class="p-6 pt-0 space-y-3">
                            <div class="text-muted-foreground">データを読み込み中...</div>
                        </div>
                    </div>
                </div>

                <!-- メインコンテンツ -->
                <div class="lg:col-span-2 space-y-6">
                    <div id="loading" class="text-center py-8">
                        <p>データを読み込み中...</p>
                    </div>

                    <!-- チャート -->
                    <div id="chart-container" class="bg-card text-card-foreground rounded-lg border shadow-sm" style="display: none;">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">波・風情報チャート</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground w-full mb-4">
                                <button id="wave-tab" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex-1 gap-2" data-state="active">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                    波高
                                </button>
                                <button id="wind-tab" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex-1 gap-2">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                    </svg>
                                    風速
                                </button>
                            </div>
                            
                            <div class="h-64">
                                <canvas id="waveChart" style="display: block;"></canvas>
                                <canvas id="windChart" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- データテーブル -->
                    <div id="table-container" class="bg-card text-card-foreground rounded-lg border shadow-sm" style="display: none;">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight">詳細データ</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table id="wave-table" class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">時刻</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">波高</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">波向</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">風速</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">風向</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">コンディション</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body" class="[&_tr:last-child]:border-0">
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
        let waveChart, windChart;
        let currentData = [];

        // 初期化
        document.addEventListener('DOMContentLoaded', function() {
            updateDateDisplay();
            fetchWaveData();

            // イベントリスナー
            document.getElementById('spot-selector').addEventListener('change', fetchWaveData);
            document.getElementById('date-selector').addEventListener('change', function() {
                updateDateDisplay();
                fetchWaveData();
            });
            document.getElementById('prev-day').addEventListener('click', changeDateBy(-1));
            document.getElementById('next-day').addEventListener('click', changeDateBy(1));
            document.getElementById('wave-tab').addEventListener('click', () => showChart('wave'));
            document.getElementById('wind-tab').addEventListener('click', () => showChart('wind'));
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
                fetchWaveData();
            };
        }

        function fetchWaveData() {
            const spotId = document.getElementById('spot-selector').value;
            const date = document.getElementById('date-selector').value;

            document.getElementById('loading').style.display = 'block';
            document.getElementById('chart-container').style.display = 'none';
            document.getElementById('table-container').style.display = 'none';

            fetch(`/api/surf/wave-data?spot_id=${spotId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    currentData = data.wave_data;
                    updateSpotInfo(data.selected_spot, data.spot_info);
                    updateHighlights(data.wave_data);
                    updateCharts(data.wave_data);
                    updateTable(data.wave_data, data.sunset_time, data.selected_spot.coast_direction);
                    
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('chart-container').style.display = 'block';
                    document.getElementById('table-container').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching wave data:', error);
                    document.getElementById('loading').innerHTML = '<p class="text-red-500">データの取得に失敗しました</p>';
                });
        }

        function updateSpotInfo(spotData, spotInfo) {
            document.getElementById('spot-name').textContent = spotData.name;
            document.getElementById('spot-location').textContent = spotData.location;
            document.getElementById('spot-description').textContent = spotInfo.description;
            document.getElementById('water-temp').textContent = `水温: ${spotInfo.water_temp}°C`;
            document.getElementById('condition-badge').textContent = spotInfo.condition;
            
            // 海岸の向き表示
            const coastDirection = document.getElementById('coast-direction');
            coastDirection.innerHTML = createDirectionIndicator(spotData.coast_direction);
        }

        function updateHighlights(waveData) {
            const bestTime = waveData.reduce((best, current) => 
                current.wave_height > best.wave_height ? current : best
            );
            const calmestWind = waveData.reduce((best, current) => 
                current.wind_speed < best.wind_speed ? current : best
            );

            const highlights = document.getElementById('highlights');
            highlights.innerHTML = `
                <div class="space-y-2">
                    <p class="text-sm font-medium">最高波高時間</p>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-green-600">${bestTime.time}</span>
                        <span class="text-sm">(${bestTime.wave_height}m)</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium">最も風が弱い時間</p>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-blue-600">${calmestWind.time}</span>
                        <span class="text-sm">(${calmestWind.wind_speed}m/s)</span>
                    </div>
                </div>
            `;
        }

        function updateCharts(waveData) {
            const labels = waveData.map(d => d.time);
            const waveHeights = waveData.map(d => d.wave_height);
            const windSpeeds = waveData.map(d => d.wind_speed);

            // 波高チャート
            const waveCtx = document.getElementById('waveChart').getContext('2d');
            if (waveChart) waveChart.destroy();
            waveChart = new Chart(waveCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '波高 (m)',
                        data: waveHeights,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '波高 (m)'
                            }
                        }
                    }
                }
            });

            // 風速チャート
            const windCtx = document.getElementById('windChart').getContext('2d');
            if (windChart) windChart.destroy();
            windChart = new Chart(windCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '風速 (m/s)',
                        data: windSpeeds,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '風速 (m/s)'
                            }
                        }
                    }
                }
            });
        }

        function showChart(type) {
            const waveTab = document.getElementById('wave-tab');
            const windTab = document.getElementById('wind-tab');
            const waveChart = document.getElementById('waveChart');
            const windChart = document.getElementById('windChart');

            if (type === 'wave') {
                waveTab.setAttribute('data-state', 'active');
                windTab.removeAttribute('data-state');
                waveChart.style.display = 'block';
                windChart.style.display = 'none';
            } else {
                windTab.setAttribute('data-state', 'active');
                waveTab.removeAttribute('data-state');
                windChart.style.display = 'block';
                waveChart.style.display = 'none';
            }
        }

        function updateTable(waveData, sunsetTime, coastDirection) {
            const tbody = document.getElementById('table-body');
            tbody.innerHTML = '';

            waveData.forEach(row => {
                const condition = getCondition(row.wind_direction, coastDirection);
                const tr = document.createElement('tr');
                tr.className = 'border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted';
                
                tr.innerHTML = `
                    <td class="p-4 align-middle">${row.time}</td>
                    <td class="p-4 align-middle">${row.wave_height}m</td>
                    <td class="p-4 align-middle">
                        <div class="flex items-center gap-2">
                            ${createDirectionIndicator(row.wave_direction)}
                            <span>${row.wave_direction}</span>
                        </div>
                    </td>
                    <td class="p-4 align-middle">${row.wind_speed}m/s</td>
                    <td class="p-4 align-middle">
                        <div class="flex items-center gap-2">
                            ${createDirectionIndicator(row.wind_direction)}
                            <span>${row.wind_direction}</span>
                        </div>
                    </td>
                    <td class="p-4 align-middle">
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 ${getConditionClass(condition)}">${condition}</span>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function createDirectionIndicator(direction) {
            const directionMap = {
                'N': 0, 'NE': 45, 'E': 90, 'SE': 135,
                'S': 180, 'SW': 225, 'W': 270, 'NW': 315
            };
            const rotation = directionMap[direction] || 0;
            
            return `
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center relative">
                    <div class="absolute w-1 h-3 bg-blue-600 rounded-full transform origin-bottom" style="transform: rotate(${rotation}deg) translateY(-25%)"></div>
                </div>
            `;
        }

        function getCondition(windDirection, coastDirection) {
            // 簡易的なコンディション判定
            const windAngle = getDirectionAngle(windDirection);
            const coastAngle = getDirectionAngle(coastDirection);
            const diff = Math.abs(windAngle - coastAngle);
            const minDiff = Math.min(diff, 360 - diff);

            if (minDiff <= 45) return 'オンショア';
            if (minDiff >= 135) return 'オフショア';
            return 'サイドショア';
        }

        function getDirectionAngle(direction) {
            const angles = {
                'N': 0, 'NE': 45, 'E': 90, 'SE': 135,
                'S': 180, 'SW': 225, 'W': 270, 'NW': 315
            };
            return angles[direction] || 0;
        }

        function getConditionClass(condition) {
            switch (condition) {
                case 'オフショア':
                    return 'border-transparent bg-green-100 text-green-800';
                case 'オンショア':
                    return 'border-transparent bg-red-100 text-red-800';
                case 'サイドショア':
                    return 'border-transparent bg-yellow-100 text-yellow-800';
                default:
                    return 'border-transparent bg-secondary text-secondary-foreground';
            }
        }
    </script>
    @endpush
</x-app-layout>