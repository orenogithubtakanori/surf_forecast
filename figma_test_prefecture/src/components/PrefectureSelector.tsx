import { Label } from './ui/label';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';

export interface Prefecture {
  name: string;
  region: string;
}

interface PrefectureSelectorProps {
  prefectures: Prefecture[];
  selectedPrefecture: string;
  onPrefectureChange: (prefecture: string) => void;
}

export function PrefectureSelector({
  prefectures,
  selectedPrefecture,
  onPrefectureChange,
}: PrefectureSelectorProps) {
  // 地域ごとにグループ化
  const groupedByRegion = prefectures.reduce((acc, pref) => {
    if (!acc[pref.region]) {
      acc[pref.region] = [];
    }
    acc[pref.region].push(pref);
    return acc;
  }, {} as { [key: string]: Prefecture[] });

  return (
    <div className="space-y-2">
      <Label htmlFor="prefecture-select">都道府県を選択</Label>
      <Select value={selectedPrefecture} onValueChange={onPrefectureChange}>
        <SelectTrigger id="prefecture-select">
          <SelectValue placeholder="都道府県を選択してください" />
        </SelectTrigger>
        <SelectContent>
          {Object.entries(groupedByRegion).map(([region, prefs]) => (
            <div key={region}>
              <div className="px-2 py-1.5 text-sm font-semibold text-muted-foreground">
                {region}
              </div>
              {prefs.map((pref) => (
                <SelectItem key={pref.name} value={pref.name}>
                  {pref.name}
                </SelectItem>
              ))}
            </div>
          ))}
        </SelectContent>
      </Select>
    </div>
  );
}
