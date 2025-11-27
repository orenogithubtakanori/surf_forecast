import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "./ui/table";
import { Card, CardContent, CardHeader, CardTitle } from "./ui/card";
import { Waves, Wind, Clock, Cloud, Thermometer } from "lucide-react";
import { DirectionIndicator } from "./DirectionIndicator";

export interface WaveData {
  time: string;
  waveHeight: number;
  waveDirection: string;
  windSpeed: number;
  windDirection: string;
  weather?: string;
  temperature?: number;
}

interface WaveDataTableProps {
  data: WaveData[];
  sunsetTime: string;
  coastDirection?: string;
}

export function WaveDataTable({ data, sunsetTime, coastDirection }: WaveDataTableProps) {
  const getWaveHeightColor = (height: number) => {
    if (height < 1) return 'text-blue-500';
    if (height < 2) return 'text-green-500';
    if (height < 3) return 'text-yellow-500';
    return 'text-red-500';
  };

  const getSurfCondition = (waveHeight: number, windSpeed: number, waveDir: string, windDir: string, coastDir?: string) => {
    if (!coastDir) return null;
    
    const directionMap: { [key: string]: number } = {
      'N': 0, 'NE': 45, 'E': 90, 'SE': 135,
      'S': 180, 'SW': 225, 'W': 270, 'NW': 315
    };
    
    const windDeg = directionMap[windDir] || 0;
    const coastDeg = directionMap[coastDir] || 0;
    let relativeDeg = Math.abs(windDeg - coastDeg);
    if (relativeDeg > 180) relativeDeg = 360 - relativeDeg;
    
    const isOffshore = relativeDeg >= 135;
    const isGoodHeight = waveHeight >= 0.8 && waveHeight <= 2.5;
    const isGoodWind = windSpeed <= 8;
    
    if (isOffshore && isGoodHeight && isGoodWind) return '◎';
    if (isOffshore && isGoodHeight) return '○';
    if (isGoodHeight && isGoodWind) return '△';
    return '×';
  };

  return (
    <Card className="w-full">
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <Waves className="h-5 w-5" />
          波情報 - 1時間ごと
        </CardTitle>
        <div className="flex items-center gap-2 text-sm text-muted-foreground">
          <Clock className="h-4 w-4" />
          日没時間: {sunsetTime}
        </div>
      </CardHeader>
      <CardContent>
        <div className="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead className="w-16">時刻</TableHead>
                <TableHead className="w-20">波高</TableHead>
                <TableHead className="w-32">波向</TableHead>
                <TableHead className="w-20">風速</TableHead>
                <TableHead className="w-32">風向</TableHead>
                <TableHead className="w-24">天気</TableHead>
                <TableHead className="w-16">気温</TableHead>
                {coastDirection && <TableHead className="w-16">評価</TableHead>}
              </TableRow>
            </TableHeader>
            <TableBody>
              {data.map((item, index) => (
                <TableRow key={index}>
                  <TableCell className="font-mono text-sm">{item.time}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Waves className="h-3 w-3" />
                      <span className={`font-semibold ${getWaveHeightColor(item.waveHeight)}`}>
                        {item.waveHeight.toFixed(1)}m
                      </span>
                    </div>
                  </TableCell>
                  <TableCell>
                    <DirectionIndicator 
                      direction={item.waveDirection}
                      coastDirection={coastDirection}
                      type="wave"
                      showRelation={true}
                      size="sm"
                    />
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Wind className="h-3 w-3" />
                      <span className="text-sm">{item.windSpeed.toFixed(1)}</span>
                    </div>
                  </TableCell>
                  <TableCell>
                    <DirectionIndicator 
                      direction={item.windDirection}
                      coastDirection={coastDirection}
                      type="wind"
                      showRelation={true}
                      size="sm"
                    />
                  </TableCell>
                  <TableCell>
                    {item.weather && (
                      <div className="flex items-center gap-1">
                        <Cloud className="h-3 w-3" />
                        <span className="text-sm">{item.weather}</span>
                      </div>
                    )}
                  </TableCell>
                  <TableCell>
                    {item.temperature !== undefined && (
                      <div className="flex items-center gap-1">
                        <Thermometer className="h-3 w-3" />
                        <span className="text-sm">{item.temperature}°C</span>
                      </div>
                    )}
                  </TableCell>
                  {coastDirection && (
                    <TableCell className="text-center">
                      <span className="text-lg">
                        {getSurfCondition(item.waveHeight, item.windSpeed, item.waveDirection, item.windDirection, coastDirection)}
                      </span>
                    </TableCell>
                  )}
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </div>
        
        {coastDirection && (
          <div className="mt-4 p-3 bg-muted rounded-lg">
            <h4 className="font-medium mb-2">評価について</h4>
            <div className="grid grid-cols-2 gap-2 text-sm">
              <div className="flex items-center gap-2">
                <span className="text-lg">◎</span>
                <span>最高のコンディション</span>
              </div>
              <div className="flex items-center gap-2">
                <span className="text-lg">○</span>
                <span>良好なコンディション</span>
              </div>
              <div className="flex items-center gap-2">
                <span className="text-lg">△</span>
                <span>普通のコンディション</span>
              </div>
              <div className="flex items-center gap-2">
                <span className="text-lg">×</span>
                <span>厳しいコンディション</span>
              </div>
            </div>
          </div>
        )}
      </CardContent>
    </Card>
  );
}