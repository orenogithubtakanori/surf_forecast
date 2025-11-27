import { useState } from 'react';
import { SurfSpotSelector, Area, Location } from './components/SurfSpotSelector';
import { DateSelector } from './components/DateSelector';
import { WaveDataTable, WaveData } from './components/WaveDataTable';
import { WaveChart } from './components/WaveChart';
import { DirectionIndicator } from './components/DirectionIndicator';
import { CoastDirection } from './components/CoastDirection';
import { Card, CardContent, CardHeader, CardTitle } from './components/ui/card';
import { Badge } from './components/ui/badge';
import { Button } from './components/ui/button';
import { MapPin, Thermometer, Navigation, ArrowLeft, List } from 'lucide-react';
import PrefecturePage from './PrefecturePage';

// モックデータ: areasテーブル
const mockAreas: Area[] = [
  { id: 1, name: '湘南', prefecture_name: '神奈川県', region_name: '関東' },
  { id: 2, name: '九十九里', prefecture_name: '千葉県', region_name: '関東' },
  { id: 3, name: '伊豆', prefecture_name: '静岡県', region_name: '東海' },
  { id: 4, name: '紀伊', prefecture_name: '和歌山県', region_name: '関西' },
  { id: 5, name: '外房', prefecture_name: '千葉県', region_name: '関東' },
];

// モックデータ: locationsテーブル
const mockLocations: Location[] = [
  { id: 1, area_id: 1, name: '鎌倉', shoreline_direction: 'S' },
  { id: 2, area_id: 1, name: '藤沢', shoreline_direction: 'S' },
  { id: 3, area_id: 1, name: '茅ヶ崎', shoreline_direction: 'S' },
  { id: 4, area_id: 1, name: '平塚', shoreline_direction: 'S' },
  { id: 5, area_id: 1, name: '湯河原', shoreline_direction: 'SE' },
  { id: 6, area_id: 2, name: '片貝', shoreline_direction: 'E' },
  { id: 7, area_id: 2, name: '一宮', shoreline_direction: 'E' },
  { id: 8, area_id: 5, name: '太東', shoreline_direction: 'E' },
  { id: 9, area_id: 5, name: '夷隅', shoreline_direction: 'E' },
  { id: 10, area_id: 3, name: '静波海岸', shoreline_direction: 'SE' },
  { id: 11, area_id: 3, name: '御前崎', shoreline_direction: 'S' },
  { id: 12, area_id: 4, name: '磯ノ浦', shoreline_direction: 'W' },
];

// 天気の選択肢
const weatherOptions = ['晴れ', '曇り', '雨', '晴れ時々曇り', '曇り時々晴れ'];

// モックデータ生成: scoresテーブル
const generateMockData = (locationId: number, date: string): WaveData[] => {
  const location = mockLocations.find(loc => loc.id === locationId);
  if (!location) return [];
  
  // ロケーションごとの特徴を定義
  const baseWaveHeight = location.area_id === 2 ? 1.8 : location.area_id === 1 ? 1.2 : 1.5;
  
  // 海岸の向きに基づいて主要な波向を設定
  const getMainWaveDirections = (direction: string): string[] => {
    const dirMap: { [key: string]: string[] } = {
      'S': ['S', 'SE', 'SW'],
      'E': ['E', 'SE', 'NE'],
      'SE': ['SE', 'S', 'E'],
      'W': ['W', 'SW', 'NW'],
      'N': ['N', 'NE', 'NW'],
    };
    return dirMap[direction] || ['S', 'SE', 'SW'];
  };
  
  // オフショア方向の風向を生成
  const getOffshoreWindDirections = (direction: string): string[] => {
    const dirMap: { [key: string]: string[] } = {
      'S': ['N', 'NE', 'NW'],
      'E': ['W', 'NW', 'SW'],
      'SE': ['NW', 'N', 'W'],
      'W': ['E', 'SE', 'NE'],
      'N': ['S', 'SE', 'SW'],
    };
    return dirMap[direction] || ['N', 'NE', 'NW'];
  };
  
  const waveDirections = getMainWaveDirections(location.shoreline_direction);
  const windDirections = getOffshoreWindDirections(location.shoreline_direction);
  
  const data: WaveData[] = [];
  
  for (let hour = 6; hour <= 18; hour++) {
    const variation = Math.sin(hour / 24 * Math.PI * 2) * 0.5 + Math.random() * 0.3 - 0.15;
    const waveHeight = Math.max(0.3, baseWaveHeight + variation);
    
    const waveDirection = waveDirections[Math.floor(Math.random() * waveDirections.length)];
    const windDirection = windDirections[Math.floor(Math.random() * windDirections.length)];
    const weather = weatherOptions[Math.floor(Math.random() * weatherOptions.length)];
    const temperature = Math.round(18 + Math.random() * 8 + Math.sin(hour / 24 * Math.PI * 2) * 3);
    
    data.push({
      time: `${hour.toString().padStart(2, '0')}:00`,
      waveHeight: Math.round(waveHeight * 10) / 10,
      waveDirection,
      windSpeed: Math.round((3 + Math.random() * 8) * 10) / 10,
      windDirection,
      weather,
      temperature,
    });
  }
  
  return data;
};

const getSunsetTime = (locationId: number, date: string) => {
  const location = mockLocations.find(loc => loc.id === locationId);
  if (!location) return '17:40';
  
  // エリアごとの日没時間シミュレーション
  const sunsetTimes: { [key: number]: string } = {
    1: '17:42', // 湘南
    2: '17:38', // 九十九里
    3: '17:45', // 伊豆
    4: '17:51', // 紀伊
    5: '17:38', // 外房
  };
  return sunsetTimes[location.area_id] || '17:40';
};

const getLocationInfo = (locationId: number) => {
  const location = mockLocations.find(loc => loc.id === locationId);
  if (!location) return { waterTemp: 16, condition: 'やや良好', description: '' };
  
  // エリアごとの特性
  const areaInfo: { [key: number]: { waterTemp: number, condition: string, descriptionBase: string } } = {
    1: { waterTemp: 16, condition: 'やや良好', descriptionBase: '初心者から上級者まで楽しめる人気スポット' },
    2: { waterTemp: 15, condition: '良好', descriptionBase: '安定した波質で練習に最適' },
    3: { waterTemp: 17, condition: '良好', descriptionBase: '水質が良く景色も美しい' },
    4: { waterTemp: 18, condition: 'かなり良好', descriptionBase: '関西屈指のサーフポイント' },
    5: { waterTemp: 15, condition: '良好', descriptionBase: 'パワフルな波が特徴' },
  };
  
  const info = areaInfo[location.area_id] || { waterTemp: 16, condition: 'やや良好', descriptionBase: '' };
  return {
    ...info,
    description: info.descriptionBase
  };
};

function DetailPage({ 
  locationId, 
  onBackToList 
}: { 
  locationId: number; 
  onBackToList: () => void;
}) {
  const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split('T')[0]);

  const waveData = generateMockData(locationId, selectedDate);
  const sunsetTime = getSunsetTime(locationId, selectedDate);
  const locationInfo = getLocationInfo(locationId);
  const currentLocation = mockLocations.find(loc => loc.id === locationId);
  const currentArea = currentLocation ? mockAreas.find(area => area.id === currentLocation.area_id) : null;

  return (
    <div className="min-h-screen bg-background p-4 md:p-6">
      <div className="mx-auto max-w-7xl space-y-6">
        <header className="space-y-4">
          <Button
            variant="outline"
            onClick={onBackToList}
            className="mb-2"
          >
            <ArrowLeft className="h-4 w-4 mr-2" />
            スポット一覧に戻る
          </Button>
          <div className="text-center space-y-2">
            <h1 className="text-3xl font-bold">サーフィンスポット波情報</h1>
            <p className="text-muted-foreground">
              リアルタイムの波高・風速情報で最適なサーフィンタイムを見つけよう
            </p>
          </div>
        </header>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div className="lg:col-span-1 space-y-4">
            <Card>
              <CardHeader>
                <CardTitle>日付選択</CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <DateSelector
                  selectedDate={selectedDate}
                  onDateChange={setSelectedDate}
                />
              </CardContent>
            </Card>

            {currentLocation && currentArea && (
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <MapPin className="h-5 w-5" />
                    スポット情報
                  </CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div>
                    <p className="font-semibold">{currentLocation.name}</p>
                    <p className="text-sm text-muted-foreground">
                      {currentArea.name} - {currentArea.prefecture_name}（{currentArea.region_name}）
                    </p>
                    <p className="text-sm mt-1">{locationInfo.description}</p>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center gap-2">
                      <Navigation className="h-4 w-4 text-blue-600" />
                      <span className="text-sm font-medium">海岸の向き:</span>
                    </div>
                    <div className="ml-6">
                      <CoastDirection direction={currentLocation.shoreline_direction} />
                    </div>
                  </div>

                  <div className="flex items-center gap-2">
                    <Thermometer className="h-4 w-4" />
                    <span className="text-sm">水温: {locationInfo.waterTemp}°C</span>
                  </div>
                  
                  <div>
                    <Badge variant="secondary">{locationInfo.condition}</Badge>
                  </div>
                </CardContent>
              </Card>
            )}

            <Card>
              <CardHeader>
                <CardTitle>今日のハイライト</CardTitle>
              </CardHeader>
              <CardContent className="space-y-3">
                {(() => {
                  const bestTime = waveData.reduce((best, current) => 
                    current.waveHeight > best.waveHeight ? current : best
                  );
                  const calmestWind = waveData.reduce((best, current) => 
                    current.windSpeed < best.windSpeed ? current : best
                  );
                  
                  return (
                    <>
                      <div className="space-y-2">
                        <p className="text-sm font-medium">最高波高時間</p>
                        <div className="flex items-center gap-2">
                          <span className="text-lg font-bold text-green-600">{bestTime.time}</span>
                          <span className="text-sm">({bestTime.waveHeight}m)</span>
                        </div>
                      </div>
                      
                      <div className="space-y-2">
                        <p className="text-sm font-medium">最も風が弱い時間</p>
                        <div className="flex items-center gap-2">
                          <span className="text-lg font-bold text-blue-600">{calmestWind.time}</span>
                          <span className="text-sm">({calmestWind.windSpeed}m/s)</span>
                        </div>
                      </div>
                    </>
                  );
                })()}
              </CardContent>
            </Card>
          </div>

          <div className="lg:col-span-2 space-y-6">
            <WaveChart data={waveData} />
            <WaveDataTable 
              data={waveData} 
              sunsetTime={sunsetTime}
              coastDirection={currentLocation?.shoreline_direction}
            />
          </div>
        </div>

        <footer className="text-center text-sm text-muted-foreground pt-8 border-t">
          <p>※ これはデモデータです。実際の波情報ではありません。</p>
        </footer>
      </div>
    </div>
  );
}

export default function App() {
  const [currentView, setCurrentView] = useState<'list' | 'detail'>('list');
  const [selectedLocationId, setSelectedLocationId] = useState<number>(1);

  const handleSpotSelect = (locationId: number) => {
    setSelectedLocationId(locationId);
    setCurrentView('detail');
  };

  const handleBackToList = () => {
    setCurrentView('list');
  };

  if (currentView === 'detail') {
    return (
      <DetailPage 
        locationId={selectedLocationId}
        onBackToList={handleBackToList}
      />
    );
  }

  return <PrefecturePage onSpotSelect={handleSpotSelect} />;
}
