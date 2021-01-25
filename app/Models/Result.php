<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = ['id'];
    protected $table = 'results';


    public function student()
    {
        $this->belongsTo(Student::class,'student_id');
    }
    public function subject()
    {
       return $this->hasOne('Portal\Models\Subject', 'id', 'subject_id');
    }


    public function getGradeAttribute()
    {
        if($this->total > 79){
            return 'A';
        }elseif ($this->total > 59 && $this->total < 80){
            return 'B';
        }elseif ($this->total > 49 && $this->total < 60){
            return 'C';
        }elseif ($this->total > 39 && $this->total < 50){
            return 'D';
        }elseif($this->total < 40){
            return 'F';
        }
    }


    public function getRemarkAttribute()
    {
        if($this->total >= 80){
            return 'Excellent';
        }elseif($this->total >= 70 && $this->total < 80 ){
            return 'Very Good';
        }elseif ($this->total >= 60 && $this->total < 70){
            return 'Good';
        }elseif ($this->total >= 50 && $this->total < 60){
            return 'Credit';
        }elseif ($this->total >= 40 && $this->total < 50){
            return 'Fair';
        }else{
            return 'Poor';
        }
    }

    public function allResults()
    {
       $all = Result::where('class', $this->class)
            ->where('div', $this->div)->where('term', $this->term)
            ->where('session', $this->session)->where('subject_id', $this->subject_id)->get();

       return $all;
    }

    public function getClassAverageAttribute()
    {
        $results = $this->allResults();
        $sum = $results->sum('total');
        //$highest = $results->sortByDesc('total');
        //$this->attributes['class_highest'] = $highest->get(0)->total;
        $lowest = $results->sortBy('total');
        $this->attributes['class_lowest'] = $lowest->first()->total;

        return round(($sum/count($results)), 1);
    }

    public function getClassHighestAttribute()
    {
        $high = $this->allResults()->sortBy('total');

        return $high->last()->total;
    }

    public function getPositionsAttribute() {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($this->position % 100) >= 11) && (($this->position%100) <= 13))
            return $this->position. 'th';
        else
            return $this->position. $ends[$this->position % 10];
    }

    public function getTotalAttribute()
    {
        return round(($this->ca1+$this->ca2+$this->exam), 1);
    }

    public function getSubjectTitleAttribute()
    {
        return $this->subject->title;
    }

    public function grade($total)
    {
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

    public function remark($total)
    {
        if($total > 79){
            return 'Excellent';
        }elseif ($total > 70 && $total < 80){
            return 'Very Good';
        }elseif ($total > 59 && $total < 80){
            return 'Good';
        }elseif ($total > 49 && $total < 60){
            return 'Credit';
        }elseif ($total > 39 && $total < 50){
            return 'Poor';
        }elseif($total < 40){
            return 'Fail';
        }
    }

}
