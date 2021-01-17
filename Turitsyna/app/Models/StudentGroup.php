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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\Status $status
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student_group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Student_group extends Model
{
    use HasFactory;
    protected $table = 'student_group';
    protected $primaryKey = 'id';

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
