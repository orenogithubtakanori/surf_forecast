import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from "./ui/select";

export interface Area {
  id: number;
  name: string;
  prefecture_name: string;
  region_name: string;
}

export interface Location {
  id: number;
  area_id: number;
  name: string;
  shoreline_direction: string;
}

interface SurfSpotSelectorProps {
  areas: Area[];
  locations: Location[];
  selectedLocation: number;
  onLocationChange: (locationId: number) => void;
}

export function SurfSpotSelector({ areas, locations, selectedLocation, onLocationChange }: SurfSpotSelectorProps) {
  // エリアごとにロケーションをグループ化
  const groupedLocations = areas.map(area => ({
    area,
    locations: locations.filter(loc => loc.area_id === area.id)
  })).filter(group => group.locations.length > 0);

  return (
    <div className="space-y-2">
      <label className="block">サーフスポット</label>
      <Select 
        value={selectedLocation.toString()} 
        onValueChange={(value) => onLocationChange(parseInt(value))}
      >
        <SelectTrigger className="w-full">
          <SelectValue placeholder="サーフスポットを選択してください" />
        </SelectTrigger>
        <SelectContent>
          {groupedLocations.map(({ area, locations }) => (
            <SelectGroup key={area.id}>
              <SelectLabel>{area.name} ({area.prefecture_name})</SelectLabel>
              {locations.map((location) => (
                <SelectItem key={location.id} value={location.id.toString()}>
                  {location.name}
                </SelectItem>
              ))}
            </SelectGroup>
          ))}
        </SelectContent>
      </Select>
    </div>
  );
}