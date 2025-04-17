<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'place_id',
        'game',
        'date',
        'start_time',
        'end_time',
        'time',
        'interval',
        'preliminary_group',
        'qualifying_interval',
        'semi_final_interval',
        'final_interval',
        'number_of_matches',
        'people',
        'half_time_check',
        'half_time',
    ];

    // 中間テーブルのリレーション
    public function opponents()
    {
        return $this->belongsToMany(Opponent::class, 'schedule_opponent');
    }

    public function schoolYears()
    {
        return $this->belongsToMany(SchoolYear::class, 'schedule_school_year');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
