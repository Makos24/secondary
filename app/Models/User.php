<?php

namespace Portal\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function positions()
    {
        return $this->hasMany('Portal\Models\Position', 'student_id', 'student_id');
    }

    public function rates()
    {
        return $this->hasMany('Portal\Models\Rate', 'student_id', 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany('Portal\Models\Attendance', 'student_id', 'student_id');
    }

    public function results()
    {
        return $this->hasMany('Portal\Models\Result', 'student_id', 'student_id');
    }

    public function getStudentClassAttribute()
    {
        if($this->level <= 3){
            return "NURSERY ".$this->level."".$this->class;
        }elseif ($this->level > 3 && $this->level < 10) {
            return "PRIMARY ".($this->level - 3)."".$this->class;
        }elseif ($this->level > 9 && $this->level < 13){
            return "JSS ".($this->level - 9)."".$this->class;
        }elseif ($this->level > 12 && $this->level < 16){
            return "SS ".($this->level - 12)."".$this->class;
        }
    }

    public function getStudentClassNameAttribute()
    {
        if($this->level <= 3){
            return "NURSERY ".$this->level."".$this->class;
        }elseif ($this->level > 3 && $this->level < 10) {
            return "PRIMARY ".($this->level - 3)."".$this->class;
        }elseif ($this->level > 9 && $this->level < 13){
            return "JSS ".($this->level - 9)."".$this->class;
        }elseif ($this->level > 12 && $this->level < 16){
            return "SS ".($this->level - 12)."".$this->class;
        }
    }

    public function getClass(){
        if($this->level <= 3){
            return "NURSERY ".$this->level."".$this->class;
        }elseif ($this->level > 3 && $this->level < 10) {
            return "PRIMARY ".($this->level - 3)."".$this->class;
        }elseif ($this->level > 9 && $this->level < 13){
            return "JSS ".($this->level - 9)."".$this->class;
        }elseif ($this->level > 12 && $this->level < 16){
            return "SS ".($this->level - 12)."".$this->class;
        }
    }
    public function getClassName($level)
    {
        if($level <= 3){
            return "NURSERY ".$level;
        }elseif ($level > 3 && $level < 10) {
            return "PRIMARY ".($level - 3);
        }elseif ($level > 9 && $level < 13){
            return "JSS ".($level - 9);
        }elseif ($level > 12 && $level < 16){
            return "SS ".($level - 12);
        }
    }
    public function getName()
    {
        return $this->first_name." ".$this->last_name." ".$this->other_name;
    }

    public function getN()
    {
        if(isset($this->name)){
            return $this->name;
        }else if(isset($this->first_name)){
            return $this->first_name;
        }
    }

    public function behaviour($val)
    {
        if($val == 1){
            return 'WELL BEHAVED';
        }elseif($val == 2){
            return 'GOOD CONDUCT';
        }elseif($val == 3){
            return 'GOOD';
        }elseif($val == 4){
            return 'SATISFACTORY';
        }elseif($val == 5){
            return 'NAUGHTY';
        }
    }

    public function appearance($val){
        if($val == 1){
            return 'SMART';
        }elseif($val == 2){
            return 'NEAT';
        }elseif($val == 3){
            return 'GOOD';
        }elseif($val == 4){
            return 'DIRTY';
        }elseif($val == 5){
            return 'ROUGH';
        }
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function comment($grade){
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
                return 'A very good result. You can do even better. Raise the bar upper!';
            }elseif ($grade >= 65 && $grade < 70){
                return 'A good result. Even though, you can do much better.';
            }elseif ($grade >= 60 && $grade < 66){
                return 'A good performance. Though, you can do much better.';
            }elseif ($grade >= 50 && $grade < 60){
                return 'An average performance. You can go beyond average by working harder.';
            }elseif ($grade >= 47 && $grade < 50){
                return 'A fairly good result. With self confidence work harder next term';
            }elseif ($grade >= 45  && $grade < 47){
                return 'A fair performance build your confidence next term';
            }elseif ($grade >= 43 && $grade < 45){
                return 'A weak pass you can make it better';
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

    public function pComment($grade){
        if ($grade >= 94){
            return 'Impressive Result';
        }elseif ($grade >= 90 && $grade < 94){
            return 'Impressive performance';
        }elseif ($grade >= 86 && $grade < 90){
            return 'Colourful Result';
        }elseif ($grade >= 84 && $grade < 86){
            return 'I am proud of you!';
        }elseif ($grade >= 80 && $grade < 84){
            return 'A great Performance indeed!';
        }elseif ($grade >= 76 && $grade < 80){
            return 'You have put up a very good result. Even so, you can do better.';
        }elseif ($grade >= 73 && $grade < 76){
            return 'You can still add to this performance';
        }elseif ($grade >= 70 && $grade < 76){
            return 'You have room for excellence. Enter in.';
        }elseif ($grade >= 68 && $grade < 70){
            return 'Do not relent.';
        }elseif ($grade >= 66 && $grade < 68){
            return 'You can still pull a tougher competition.';
        }elseif ($grade >= 64 && $grade < 66){
            return 'You have the potential to compete better.';
        }elseif ($grade >= 62 && $grade < 64){
            return 'You can put up a better competition next term.';
        }elseif ($grade >= 60 && $grade < 62){
            return 'You can make a better competition next term.';
        }elseif ($grade >= 55 && $grade < 60){
            return 'Improve on your weaker subjects. You will certainly come better.';
        }elseif ($grade >= 50 && $grade < 55){
            return 'Work on your weaker subjects. You will certainly come better.';
        }elseif ($grade >= 47 && $grade < 50){
            return 'Determine to pass all you subjects next term.';
        }elseif ($grade >= 44  && $grade < 47){
            return 'Resolve not to fail any subject next term';
        }elseif ($grade >= 40 && $grade < 44){
            return 'You must sit up.';
        }elseif ($grade >= 30 && $grade < 40){
            return 'Put more effort to improve.';
        }elseif ($grade >= 20 && $grade < 30){
            return 'Make serious effort to wake up.';
        }elseif ($grade >= 0 && $grade < 20){
            return 'Make deep commitment to enhance your understanding and wake up.';
        }

    }

    public function getClassTeacherAttribute()
    {
        $user = User::where('is_staff', true)->where('level', $this->level)->where('class',$this->class)->first();
        if ($user){
            return $user->name;
        }
        return null;
    }

    public function scopeStudents($query)
    {
        return $query->where('active', true)->where('is_staff', false)->where('is_admin', false);
    }
}