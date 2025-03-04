<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Didactic extends Model
{
    public $timestamps=false;

    protected $table = 'didactics';

    protected $fillable = [
        'data','url','people_id',
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
