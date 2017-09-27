<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBreakfast extends Model
{
    //
    protected $fillable = ['user_id', 'begin_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
