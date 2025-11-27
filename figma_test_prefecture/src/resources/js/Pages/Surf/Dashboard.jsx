import { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import SurfSpotSelector from '@/Components/Surf/SurfSpotSelector';
import DateSelector from '@/Components/Surf/DateSelector';
import WaveDataTable from '@/Components/Surf/WaveDataTable';
import WaveChart from '@/Components/Surf/WaveChart';
import CoastDirection from '@/Components/Surf/CoastDirection';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { MapPin, Thermometer, Navigation } from 'lucide-react';

export default function Dashboard({ auth, surfSpots, initialDate }) {
    const [selectedSpot, setSelectedSpot] = useState('shonan');
    const [selectedDate, setSelectedDate] = useState(initialDate);
    const [waveData, setWaveData] = useState([]);
    const [sunsetTime, setSunsetTime] = useState('');
    const [spotInfo, setSpotInfo] = useState({});
    const [loading, setLoading] = useState(false);

    const selectedSpotData = surfSpots.find(spot => spot.id === selectedSpot);

    const fetchWaveData = async () => {
        setLoading(true);
        try {
            const response = await fetch(`/api/surf/wave-data?spot_id=${selectedSpot}&date=${selectedDate}`);
            const data = await response.json();
            
            setWaveData(data.wave_data);
            setSunsetTime(data.sunset_time);
            setSpotInfo(data.spot_info);
        } catch (error) {
            console.error('Error fetching wave data:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchWaveData();
    }, [selectedSpot, selectedDate]);

    const getBestTime = () => {
        if (waveData.length === 0) return null;
        return waveData.reduce((best, current) => 
            current.wave_height > best.wave_height ? current : best
        );
    };

    const getCalmestWind = () => {
        if (waveData.length === 0) return null;
        return waveData.reduce((best, current) => 
            current.wind_speed < best.wind_speed ? current : best
        );
    };

    return (
        <AuthenticatedLayout
            user={auth?.user}
            header={
                <div className="text-center space-y-2">
                    <h2 className="text-3xl font-bold">サーフィンスポット波情報</h2>
                    <p className="text-muted-foreground">
                        リアルタイムの波高・風速情報で最適なサーフィンタイムを見つけよう
                    </p>
                </div>
            }
        >
            <Head title="サーフィン波情報" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl space-y-6 px-4 md:px-6">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div className="lg:col-span-1 space-y-4">
                            <Card>
                                <CardHeader>
                                    <CardTitle>検索条件</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <SurfSpotSelector
                                        spots={surfSpots}
                                        selectedSpot={selectedSpot}
                                        onSpotChange={setSelectedSpot}
                                    />
                                    <DateSelector
                                        selectedDate={selectedDate}
                                        onDateChange={setSelectedDate}
                                    />
                                </CardContent>
                            </Card>

                            {selectedSpotData && (
                                <Card>
                                    <CardHeader>
                                        <CardTitle className="flex items-center gap-2">
                                            <MapPin className="h-5 w-5" />
                                            スポット情報
                                        </CardTitle>
                                    </CardHeader>
                                    <CardContent className="space-y-4">
                                        <div>
                                            <p className="font-semibold">{selectedSpotData.name}</p>
                                            <p className="text-sm text-muted-foreground">{selectedSpotData.location}</p>
                                            <p className="text-sm mt-1">{spotInfo.description}</p>
                                        </div>
                                        
                                        <div className="space-y-3">
                                            <div className="flex items-center gap-2">
                                                <Navigation className="h-4 w-4 text-blue-600" />
                                                <span className="text-sm font-medium">海岸の向き:</span>
                                            </div>
                                            <div className="ml-6">
                                                <CoastDirection direction={selectedSpotData.coast_direction} />
                                            </div>
                                        </div>

                                        <div className="flex items-center gap-2">
                                            <Thermometer className="h-4 w-4" />
                                            <span className="text-sm">水温: {spotInfo.water_temp}°C</span>
                                        </div>
                                        
                                        <div>
                                            <Badge variant="secondary">{spotInfo.condition}</Badge>
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
                                        const bestTime = getBestTime();
                                        const calmestWind = getCalmestWind();
                                        
                                        if (!bestTime || !calmestWind) {
                                            return <p className="text-muted-foreground">データを読み込み中...</p>;
                                        }
                                        
                                        return (
                                            <>
                                                <div className="space-y-2">
                                                    <p className="text-sm font-medium">最高波高時間</p>
                                                    <div className="flex items-center gap-2">
                                                        <span className="text-lg font-bold text-green-600">{bestTime.time}</span>
                                                        <span className="text-sm">({bestTime.wave_height}m)</span>
                                                    </div>
                                                </div>
                                                
                                                <div className="space-y-2">
                                                    <p className="text-sm font-medium">最も風が弱い時間</p>
                                                    <div className="flex items-center gap-2">
                                                        <span className="text-lg font-bold text-blue-600">{calmestWind.time}</span>
                                                        <span className="text-sm">({calmestWind.wind_speed}m/s)</span>
                                                    </div>
                                                </div>
                                            </>
                                        );
                                    })()}
                                </CardContent>
                            </Card>
                        </div>

                        <div className="lg:col-span-2 space-y-6">
                            {loading ? (
                                <div className="text-center py-8">
                                    <p>データを読み込み中...</p>
                                </div>
                            ) : (
                                <>
                                    <WaveChart data={waveData} />
                                    <WaveDataTable 
                                        data={waveData} 
                                        sunsetTime={sunsetTime}
                                        coastDirection={selectedSpotData?.coast_direction}
                                    />
                                </>
                            )}
                        </div>
                    </div>

                    <footer className="text-center text-sm text-muted-foreground pt-8 border-t">
                        <p>※ これはデモデータです。実際の波情報ではありません。</p>
                    </footer>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}