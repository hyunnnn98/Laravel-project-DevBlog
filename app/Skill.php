<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Skill extends Model
{
    use Notifiable;

    /* 기본키 설정 */
    protected $primaryKey = 'id';

    protected $guarded = [];
}
