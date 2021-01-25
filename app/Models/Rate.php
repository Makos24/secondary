<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $guarded = ['id'];
    protected $table = 'rates';

    public function total(){
        return $this->punctuality+$this->attendance+$this->assignments+$this->perseverance+$this->self_control+
        $this->self_confidence+$this->endurance+$this->respect+$this->relationship+$this->leadership+
        $this->honesty+$this->neatness+$this->responsibility+$this->sports+$this->skills+$this->group_projects;
    }
}
