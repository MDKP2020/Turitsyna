<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudyYear
 *
 * @property int $id
 * @property int $start_year
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyYear whereStartYear($value)
 * @mixin \Eloquent
 */
class StudyYear extends  Model
{
    use HasFactory;
    protected $table = 'study_year';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function groups(){
        return $this->hasMany('App\Models\Group');
    }

}
