<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = ['id'];
    protected $table = 'positions';

    public function student()
    {
        return $this->belongsTo('Portal\Models\User', 'student_id', 'student_id');
    }

    public function getPositionAttribute($number)
    {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function getOverallPosAttribute($number)
    {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function getNumberInClassAttribute()
    {
       return Position::where('level',$this->level)->where('class',$this->class)
                        ->where('term',$this->term)->where('session',$this->session)->count();
    }

    public function getCommentAttribute(){
        $grade = $this->average;
        if(session()->get('section') == "primary"){
            if($grade > 0 && $grade < 4){
                return 'Excellent performance. Keep it up!';
            }elseif ($grade > 3 && $grade < 11){
                return 'Very Good performance. You can do better.';
            }elseif ($grade > 10 && $grade < 16){
                return 'Good result. Work hard next term';
            }else{
                return 'Fair result. Work harder next term';
            }
        }else if(session()->get('section') == "secondary"){
            if ($grade >= 90){
                return 'An Excellent result. Keep it up!';
            }elseif ($grade >= 80 && $grade < 90){
                return 'You made an Excellent performance. Keep it up!';
            }elseif ($grade >= 75 && $grade < 80){
                return 'A very good result. However, you have room for improvement. Raise it up!';
            }elseif ($grade >= 70 && $grade < 76){
                return 'A very good result. You can do even better. Raise the bar higher!';
            }elseif ($grade >= 65 && $grade < 70){
                return 'A good result. Even though, you can do much better.';
            }elseif ($grade >= 60 && $grade < 66){
                return 'A good performance. Though, you can do much better.';
            }elseif ($grade >= 50 && $grade < 60){
                return 'An average performance. You can go beyond average by working harder.';
            }elseif ($grade >= 47 && $grade < 50){
                return 'A fairly good result. With self confidence work harder next term';
            }elseif ($grade >= 45  && $grade < 47){
                return 'A fair performance, build your confidence next term';
            }elseif ($grade >= 43 && $grade < 45){
                return 'A weak pass, you can make it better';
            }elseif ($grade >= 40 && $grade < 43){
                return 'A fair result, but you will have to work harder next term';
            }elseif ($grade >= 30 && $grade < 40){
                return 'A poor performance. Please wake up! You can improve.';
            }elseif ($grade >= 20 && $grade < 30){
                return 'A poor result. Please wake up! You can improve next term.';
            }elseif ($grade >= 0 && $grade < 20){
                return 'A very poor result. Nevertheless, you are not a failure only wake up!';
            }
        }else{
            return redirect('/start');
        }

    }

    public function getGradeAttribute()
    {
        $total = $this->average;
        if($total > 79){
            return 'A';
        }elseif ($total > 59 && $total < 80){
            return 'B';
        }elseif ($total > 49 && $total < 60){
            return 'C';
        }elseif ($total > 39 && $total < 50){
            return 'D';
        }elseif($total < 40){
            return 'F';
        }
    }

    public function getTermSettingsAttribute()
    {
        return Termsetting::where('session', $this->session)->where('term', $this->term)->first();

    }

}
