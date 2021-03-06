<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Level_education
 *
 * @property int $id
 * @property string $name
 * @property int $period_of_study
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LevelEducation wherePeriodOfStudy($value)
 * @mixin \Eloquent
 */
class LevelEducation extends Model
{
    use HasFactory;
    protected $table = 'level_education';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function groups(){
        return $this->hasMany('App\Models\Group');
    }
}
