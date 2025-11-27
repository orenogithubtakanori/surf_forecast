import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from './components/ui/card';
import { Badge } from './components/ui/badge';
import { PrefectureSelector, Prefecture } from './components/PrefectureSelector';
import { PrefectureSpotCard } from './components/PrefectureSpotCard';
import { Area, Location } from './components/SurfSpotSelector';
import { MapPin, Navigation, Info } from 'lucide-react';

interface PrefecturePageProps {
  onSpotSelect?: (locationId: number) => void;
}

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

// 都道府県リストを生成
const getPrefectures = (): Prefecture[] => {
  const uniquePrefectures = new Map<string, string>();
  mockAreas.forEach(area => {
    uniquePrefectures.set(area.prefecture_name, area.region_name);
  });
  
  return Array.from(uniquePrefectures.entries()).map(([name, region]) => ({
    name,
    region,
  }));
};

// 都道府県ごとの説明文
const getPrefectureDescription = (prefectureName: string): string => {
  const descriptions: { [key: string]: string } = {
    '神奈川県': '神奈川県は日本を代表するサーフィンの聖地であり、湘南エリアを中心に数多くの優良なサーフスポットが点在しています。鎌倉、藤沢、茅ヶ崎、平塚など、それぞれ異なる波質と特徴を持つポイントがあり、初心者から上級者まで幅広いレベルのサーファーが楽しめる環境が整っています。都心からのアクセスが良好で、週末には多くのサーファーで賑わいます。湘南の海は南向きの海岸線が多く、南からのうねりをキャッチしやすいため、夏から秋にかけては安定した波が期待できます。また、江ノ島や富士山を望む美しい景観も魅力の一つです。',
    '千葉県': '千葉県は九十九里浜と外房エリアを中心に、日本有数のサーフィンスポットが集まっています。太平洋に面した東向きの海岸線は、北東からのうねりを受けやすく、年間を通じて安定した波が立ちます。特に一宮、片貝、太東、夷隅などは国内外から多くのサーファーが訪れる人気スポットです。プロの大会も頻繁に開催され、ハイレベルなサーフィンを目にすることができます。波のパワーとサイズが湘南に比べて大きく、中級者以上のサーファーに特に人気があります。',
    '静岡県': '静岡県の伊豆エリアは、透明度の高い海と美しい自然環境が特徴のサーフスポットです。御前崎や静波海岸など、南東から南向きの海岸線を持つポイントが多く、台風のうねりが入りやすい夏から秋にかけてがベストシーズンです。水温が比較的温かく、冬場でも快適にサーフィンを楽しむことができます。景観の美しさと波質の良さから、サーフトリップの目的地としても人気があります。',
    '和歌山県': '和歌山県の紀伊エリアは関西屈指のサーフポイントとして知られており、磯ノ浦を中心に質の高い波が楽しめます。西向きの海岸線が特徴的で、西からのうねりを受けやすく、特に冬季には良質な波が立ちます。関西圏からのアクセスが良く、温暖な気候と美しい海岸線が魅力です。比較的混雑が少なく、落ち着いてサーフィンを楽しめる環境が整っています。',
  };
  
  return descriptions[prefectureName] || 'この都道府県のサーフスポット情報をご覧いただけます。各スポットには独自の特徴があり、海岸の向きや波質によって最適な時期や条件が異なります。詳細な波情報は各スポットページでご確認ください。';
};

export default function PrefecturePage({ onSpotSelect }: PrefecturePageProps) {
  const prefectures = getPrefectures();
  const [selectedPrefecture, setSelectedPrefecture] = useState('神奈川県');

  // 選択された都道府県のエリアを取得
  const areasInPrefecture = mockAreas.filter(
    area => area.prefecture_name === selectedPrefecture
  );

  // 選択された都道府県のロケーションを取得（エリアごとにグループ化）
  const locationsByArea = areasInPrefecture.map(area => ({
    area,
    locations: mockLocations.filter(loc => loc.area_id === area.id),
  }));

  // 都道府県の説明文を取得
  const prefectureDescription = getPrefectureDescription(selectedPrefecture);

  // サーフスポットが選択された時の処理（詳細ページへ遷移など）
  const handleSpotSelect = (locationId: number) => {
    if (onSpotSelect) {
      onSpotSelect(locationId);
    } else {
      console.log('Selected location:', locationId);
      // Laravel実装時: window.location.href = `/surf/spot/${locationId}`;
      alert(`スポットID ${locationId} の詳細ページに遷移します`);
    }
  };

  return (
    <div className="min-h-screen bg-background p-4 md:p-6">
      <div className="mx-auto max-w-7xl space-y-6">
        <header className="text-center space-y-2">
          <h1 className="text-3xl font-bold">サーフスポット一覧</h1>
          <p className="text-muted-foreground">
            都道府県別のサーフィンスポットを探す
          </p>
        </header>

        <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
          <div className="lg:col-span-1 space-y-4">
            <Card>
              <CardHeader>
                <CardTitle>都道府県選択</CardTitle>
              </CardHeader>
              <CardContent>
                <PrefectureSelector
                  prefectures={prefectures}
                  selectedPrefecture={selectedPrefecture}
                  onPrefectureChange={setSelectedPrefecture}
                />
              </CardContent>
            </Card>

            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Info className="h-5 w-5" />
                  {selectedPrefecture}について
                </CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-sm text-muted-foreground leading-relaxed">
                  {prefectureDescription}
                </p>
              </CardContent>
            </Card>
          </div>

          <div className="lg:col-span-3 space-y-6">
            {locationsByArea.length === 0 ? (
              <Card>
                <CardContent className="py-12">
                  <div className="text-center text-muted-foreground">
                    <Navigation className="h-12 w-12 mx-auto mb-4 opacity-50" />
                    <p>この都道府県にはサーフスポットが登録されていません</p>
                  </div>
                </CardContent>
              </Card>
            ) : (
              locationsByArea.map(({ area, locations }) => (
                <div key={area.id} className="space-y-4">
                  <div className="flex items-center gap-3">
                    <h2 className="text-2xl font-bold">{area.name}</h2>
                    <Badge variant="secondary">
                      {locations.length}スポット
                    </Badge>
                  </div>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {locations.map(location => (
                      <PrefectureSpotCard
                        key={location.id}
                        location={location}
                        areaName={area.name}
                        onSelect={handleSpotSelect}
                      />
                    ))}
                  </div>
                </div>
              ))
            )}
          </div>
        </div>

        <footer className="text-center text-sm text-muted-foreground pt-8 border-t">
          <p>※ 各スポットをクリックすると詳細な波情報を確認できます。</p>
        </footer>
      </div>
    </div>
  );
}
