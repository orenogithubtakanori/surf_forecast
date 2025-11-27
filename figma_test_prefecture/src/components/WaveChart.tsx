import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';
import { Card, CardContent, CardHeader, CardTitle } from "./ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "./ui/tabs";
import { Waves, Wind } from "lucide-react";

export interface WaveData {
  time: string;
  waveHeight: number;
  waveDirection: string;
  windSpeed: number;
  windDirection: string;
  weather?: string;
  temperature?: number;
}

interface WaveChartProps {
  data: WaveData[];
}

export function WaveChart({ data }: WaveChartProps) {
  return (
    <Card className="w-full">
      <CardHeader>
        <CardTitle>波・風情報チャート</CardTitle>
      </CardHeader>
      <CardContent>
        <Tabs defaultValue="wave" className="w-full">
          <TabsList className="grid w-full grid-cols-2">
            <TabsTrigger value="wave" className="flex items-center gap-2">
              <Waves className="h-4 w-4" />
              波高
            </TabsTrigger>
            <TabsTrigger value="wind" className="flex items-center gap-2">
              <Wind className="h-4 w-4" />
              風速
            </TabsTrigger>
          </TabsList>
          
          <TabsContent value="wave" className="mt-4">
            <div className="h-64">
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={data}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis 
                    dataKey="time" 
                    tick={{ fontSize: 12 }}
                  />
                  <YAxis 
                    label={{ value: '波高 (m)', angle: -90, position: 'insideLeft' }}
                    tick={{ fontSize: 12 }}
                  />
                  <Tooltip 
                    labelFormatter={(label) => `時刻: ${label}`}
                    formatter={(value, name) => [`${value}m`, '波高']}
                  />
                  <Line 
                    type="monotone" 
                    dataKey="waveHeight" 
                    stroke="#0ea5e9" 
                    strokeWidth={2}
                    dot={{ fill: '#0ea5e9', strokeWidth: 2, r: 4 }}
                  />
                </LineChart>
              </ResponsiveContainer>
            </div>
          </TabsContent>
          
          <TabsContent value="wind" className="mt-4">
            <div className="h-64">
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={data}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis 
                    dataKey="time" 
                    tick={{ fontSize: 12 }}
                  />
                  <YAxis 
                    label={{ value: '風速 (m/s)', angle: -90, position: 'insideLeft' }}
                    tick={{ fontSize: 12 }}
                  />
                  <Tooltip 
                    labelFormatter={(label) => `時刻: ${label}`}
                    formatter={(value, name) => [`${value}m/s`, '風速']}
                  />
                  <Line 
                    type="monotone" 
                    dataKey="windSpeed" 
                    stroke="#22c55e" 
                    strokeWidth={2}
                    dot={{ fill: '#22c55e', strokeWidth: 2, r: 4 }}
                  />
                </LineChart>
              </ResponsiveContainer>
            </div>
          </TabsContent>
        </Tabs>
      </CardContent>
    </Card>
  );
}