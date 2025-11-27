import { Input } from "./ui/input";
import { Button } from "./ui/button";
import { Calendar, ChevronLeft, ChevronRight } from "lucide-react";

interface DateSelectorProps {
  selectedDate: string;
  onDateChange: (date: string) => void;
}

export function DateSelector({ selectedDate, onDateChange }: DateSelectorProps) {
  const today = new Date().toISOString().split('T')[0];
  
  const handlePrevDay = () => {
    const currentDate = new Date(selectedDate);
    currentDate.setDate(currentDate.getDate() - 1);
    onDateChange(currentDate.toISOString().split('T')[0]);
  };

  const handleNextDay = () => {
    const currentDate = new Date(selectedDate);
    currentDate.setDate(currentDate.getDate() + 1);
    onDateChange(currentDate.toISOString().split('T')[0]);
  };

  const formatDateDisplay = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('ja-JP', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      weekday: 'long'
    });
  };

  return (
    <div className="space-y-2">
      <label className="block">日付</label>
      <div className="flex items-center gap-2">
        <Button variant="outline" size="sm" onClick={handlePrevDay}>
          <ChevronLeft className="h-4 w-4" />
        </Button>
        <div className="flex-1 relative">
          <Input
            type="date"
            value={selectedDate}
            onChange={(e) => onDateChange(e.target.value)}
            max={new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0]}
            min={today}
          />
          <Calendar className="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground pointer-events-none" />
        </div>
        <Button variant="outline" size="sm" onClick={handleNextDay}>
          <ChevronRight className="h-4 w-4" />
        </Button>
      </div>
      <p className="text-sm text-muted-foreground">{formatDateDisplay(selectedDate)}</p>
    </div>
  );
}