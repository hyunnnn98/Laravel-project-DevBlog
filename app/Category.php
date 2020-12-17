<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    /* 기본키 설정 */
    protected $primaryKey = 'category_id';

    protected $guarded = [];
}
