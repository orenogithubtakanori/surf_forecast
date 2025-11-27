import { Card, CardContent, CardHeader, CardTitle } from './ui/card';
import { Badge } from './ui/badge';
import { CoastDirection } from './CoastDirection';
import { MapPin, Navigation, Waves } from 'lucide-react';
import { Location } from './SurfSpotSelector';

interface PrefectureSpotCardProps {
  location: Location;
  areaName: string;
  onSelect: (locationId: number) => void;
}

export function PrefectureSpotCard({ location, areaName, onSelect }: PrefectureSpotCardProps) {
  return (
    <Card 
      className="cursor-pointer hover:shadow-lg transition-shadow duration-200 hover:border-blue-500"
      onClick={() => onSelect(location.id)}
    >
      <CardHeader>
        <CardTitle className="flex items-center gap-2 text-lg">
          <Waves className="h-5 w-5 text-blue-600" />
          {location.name}
        </CardTitle>
      </CardHeader>
      <CardContent className="space-y-3">
        <div className="flex items-center gap-2">
          <MapPin className="h-4 w-4 text-muted-foreground" />
          <span className="text-sm text-muted-foreground">{areaName}</span>
        </div>
        
        <div className="space-y-2">
          <div className="flex items-center gap-2">
            <Navigation className="h-4 w-4 text-blue-600" />
            <span className="text-sm font-medium">海岸の向き</span>
          </div>
          <div className="ml-6">
            <CoastDirection direction={location.shoreline_direction} />
          </div>
        </div>

        <div className="pt-2">
          <Badge variant="outline" className="text-xs">
            詳細を見る →
          </Badge>
        </div>
      </CardContent>
    </Card>
  );
}
