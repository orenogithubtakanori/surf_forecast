<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Score extends Model
{
    use HasFactory;
    
    protected $table = 'scores';
    public static function getLatestScores()
    {
        return DB::table('scores')
            ->select('numt.*')
            ->join(DB::raw("(
                select
                    id,
                    location_id,
                    datetime,
                    wave_height,
                    wave_direction,
                    wind_speed,
                    wind_direction,
                    row_number() over(partition by datetime,location_id order by created_at desc) as num
                from
                    scores
                ) as numt"), function($join){
                    $join -> on('scores.id','=','numt.id') -> where('num','=',1);
                }
        );
    }
    
}