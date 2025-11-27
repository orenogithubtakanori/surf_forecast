import { Navigation } from "lucide-react";

interface CoastDirectionProps {
  direction: string;
  size?: 'sm' | 'md' | 'lg';
}

export function CoastDirection({ direction, size = 'md' }: CoastDirectionProps) {
  const directionMap: { [key: string]: number } = {
    'N': 0, 'NNE': 22.5, 'NE': 45, 'ENE': 67.5,
    'E': 90, 'ESE': 112.5, 'SE': 135, 'SSE': 157.5,
    'S': 180, 'SSW': 202.5, 'SW': 225, 'WSW': 247.5,
    'W': 270, 'WNW': 292.5, 'NW': 315, 'NNW': 337.5
  };

  const directionNames: { [key: string]: string } = {
    'N': '北', 'NE': '北東', 'E': '東', 'SE': '南東',
    'S': '南', 'SW': '南西', 'W': '西', 'NW': '北西'
  };

  const rotation = directionMap[direction] || 0;
  const iconSize = size === 'sm' ? 'h-3 w-3' : size === 'lg' ? 'h-6 w-6' : 'h-4 w-4';
  const textSize = size === 'sm' ? 'text-xs' : size === 'lg' ? 'text-base' : 'text-sm';

  return (
    <div className="flex items-center gap-2">
      <Navigation 
        className={`${iconSize} text-blue-600`}
        style={{ transform: `rotate(${rotation}deg)` }}
      />
      <span className={`${textSize}`}>
        {directionNames[direction] || direction}向き
      </span>
    </div>
  );
}