<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    //デフォルトだと主キーはidになるから変更
    protected $primaryKey = 'post_id';

}
