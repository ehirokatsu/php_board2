<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $guarded = array('post_id');

    public static $rules = array(
       'post_text' => 'required',
    );

    public function getData()
    {
        return $this->post_id . ': ' . $this->post_text . ' (' . $this->send_date . ')';
    }
}
