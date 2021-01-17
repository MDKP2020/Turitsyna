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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education query()
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education wherePeriodOfStudy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level_education whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Level_education extends Model
{
    use HasFactory;
    protected $table = 'level_education';
    protected $primaryKey = 'id';

    public function groups(){
        return $this->hasMany('App\Model\Group');
    }
}
