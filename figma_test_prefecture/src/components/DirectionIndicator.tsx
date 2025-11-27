import { ArrowUp } from "lucide-react";
import { Badge } from "./ui/badge";

interface DirectionIndicatorProps {
  direction: string;
  coastDirection?: string;
  type: 'wave' | 'wind';
  showRelation?: boolean;
  size?: 'sm' | 'md' | 'lg';
}

export function DirectionIndicator({ 
  direction, 
  coastDirection, 
  type, 
  showRelation = false,
  size = 'md' 
}: DirectionIndicatorProps) {
  const directionMap: { [key: string]: number } = {
    'N': 0, 'NNE': 22.5, 'NE': 45, 'ENE': 67.5,
    'E': 90, 'ESE': 112.5, 'SE': 135, 'SSE': 157.5,
    'S': 180, 'SSW': 202.5, 'SW': 225, 'WSW': 247.5,
    'W': 270, 'WNW': 292.5, 'NW': 315, 'NNW': 337.5
  };

  const getRelativeDirection = (waveDir: string, coastDir: string) => {
    if (!coastDir) return null;
    
    const waveDeg = directionMap[waveDir] || 0;
    const coastDeg = directionMap[coastDir] || 0;
    
    // 海岸に対する相対角度を計算
    let relativeDeg = Math.abs(waveDeg - coastDeg);
    if (relativeDeg > 180) relativeDeg = 360 - relativeDeg;
    
    if (relativeDeg <= 45) return 'オンショア';
    if (relativeDeg >= 135) return 'オフショア';
    return 'サイドショア';
  };

  const getRelationColor = (relation: string | null, type: string) => {
    if (!relation) return '';
    
    if (type === 'wave') {
      switch (relation) {
        case 'オンショア': return 'bg-red-100 text-red-800';
        case 'オフショア': return 'bg-green-100 text-green-800';
        case 'サイドショア': return 'bg-yellow-100 text-yellow-800';
        default: return '';
      }
    } else {
      switch (relation) {
        case 'オンショア': return 'bg-red-100 text-red-800';
        case 'オフショア': return 'bg-green-100 text-green-800';
        case 'サイドショア': return 'bg-blue-100 text-blue-800';
        default: return '';
      }
    }
  };

  const rotation = directionMap[direction] || 0;
  const relation = coastDirection ? getRelativeDirection(direction, coastDirection) : null;
  
  const iconSize = size === 'sm' ? 'h-3 w-3' : size === 'lg' ? 'h-6 w-6' : 'h-4 w-4';
  const textSize = size === 'sm' ? 'text-xs' : size === 'lg' ? 'text-base' : 'text-sm';

  return (
    <div className="flex items-center gap-2">
      <div className="relative">
        <ArrowUp 
          className={`${iconSize} transition-transform`}
          style={{ transform: `rotate(${rotation}deg)` }}
        />
      </div>
      <span className={`font-mono ${textSize}`}>{direction}</span>
      {showRelation && relation && (
        <Badge 
          variant="secondary" 
          className={`${textSize} ${getRelationColor(relation, type)}`}
        >
          {relation}
        </Badge>
      )}
    </div>
  );
}