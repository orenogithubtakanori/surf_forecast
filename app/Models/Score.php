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
        return DB::select(
            DB::raw("
                select
                    *
                from(
                    select
                        *,
                        row_number() over(partition by datetime,location_id order by created_at desc) as num
                    from
                        scores
                    ) as subquery
                where
                    num = 1
            ")
        );
    }
}