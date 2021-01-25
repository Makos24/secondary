<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    protected $fillable = ['key', 'value'];
    protected $table = 'settings';
    protected  $hidden = ['token'];
    
}
