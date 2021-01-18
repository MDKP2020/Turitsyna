<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronomyc
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePatronomyc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSurname($value)
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function student_group(){
        return $this->hasMany('App\Models\StudentGroup');
    }
}
