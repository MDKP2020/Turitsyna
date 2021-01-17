<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudyYear
 *
 * @property int $id
 * @property int $start_year
 * @property int $period_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Period $period
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudyYear extends  Model
{
    use HasFactory;
    protected $table = 'study_year';
    protected $primaryKey = 'id';

    public function groups(){
        return $this->hasMany('App\Model\Group');
    }

    public function period(){
        return $this->belongsTo('App\Models\Period');
    }
}
