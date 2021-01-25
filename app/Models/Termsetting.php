<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Termsetting extends Model
{
    protected $guarded = ['id'];
    protected $table = 'term_settings';
	protected $dates = ['close_date', 'resume_date'];
}
