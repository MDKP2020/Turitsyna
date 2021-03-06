<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Student_group
 *
 * @property int $id
 * @property string $date
 * @property int $student_id
 * @property int $group_id
 * @property int $status_id
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\Status $status
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentGroup whereStudentId($value)
 * @mixin \Eloquent
 */
class StudentGroup extends Model
{
    use HasFactory;
    protected $table = 'student_group';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }

}
