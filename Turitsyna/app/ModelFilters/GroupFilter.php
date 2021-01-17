<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class GroupFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function direction($directionId) {
        return $this->whereIn('direction_id',$directionId);
    }

    public function course($course) {
        return $this->whereIn('course', $course);
    }

    public function study_year($study_year_id) {
        return $this->related('study_year', 'study_year_id', $study_year_id);
    }
}
