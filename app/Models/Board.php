<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $guarded = array('post_id');

    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


    public function post()
    {
        return $this->hasOne('App\Models\post','post_id', 'id');
    }

    public function reply()
    {
        return $this->hasOne('App\Models\reply','post_id', 'id');
    }
}
