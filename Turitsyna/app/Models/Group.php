<?php

namespace App\Models;

use App\ModelFilters\GroupFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Group
 *
 * @property int $id
 * @property string $name
 * @property int $lvl_education_id
 * @property int $study_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $course
 * @property int $direction_id
 * @property-read \App\Models\Direction $direction
 * @property-read \App\Models\StudyYear $studyYear
 * @method static \Illuminate\Database\Eloquent\Builder|Group filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereEducFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereLvlEducationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereStudyYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
    use Filterable;
    use HasFactory;
    protected $table = 'group';
    protected $primaryKey = 'id';

    public function direction(){
        return $this->belongsTo('App\Models\Direction');
    }

    public function studyYear(){
        return $this->belongsTo('App\Models\StudyYear');
    }

    public function levelEducation(){
        return $this->belongsTo('App\Models\LevelEducation');
    }

    public function student_group(){
        return $this->hasMany('App\Model\StudentGroup');
    }

    public function modelFilter()
    {
        return $this->provideFilter(GroupFilter::class);
    }
}
