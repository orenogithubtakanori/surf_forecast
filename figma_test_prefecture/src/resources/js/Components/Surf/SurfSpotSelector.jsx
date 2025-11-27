import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";

export default function SurfSpotSelector({ spots, selectedSpot, onSpotChange }) {
  return (
    <div className="space-y-2">
      <label className="block">サーフスポット</label>
      <Select value={selectedSpot} onValueChange={onSpotChange}>
        <SelectTrigger className="w-full">
          <SelectValue placeholder="サーフスポットを選択してください" />
        </SelectTrigger>
        <SelectContent>
          {spots.map((spot) => (
            <SelectItem key={spot.id} value={spot.id}>
              {spot.name} - {spot.location}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>
    </div>
  );
}