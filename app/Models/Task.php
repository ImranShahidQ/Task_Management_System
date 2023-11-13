<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'due_date', 'location', 'weather_info', 'temperature', 'weather_condition', 'latitude', 'longitude',
    ];

    protected $dates = ['due_date', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();;
    }
}
