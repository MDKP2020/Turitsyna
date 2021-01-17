<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Direction
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Direction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Direction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direction whereName($value)
 * @mixin \Eloquent
 */
class Direction extends Model
{
    use HasFactory;
    protected $table = 'direction';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';
    public $timestamps = false;
    public function groups(){
        return $this->hasMany('App\Model\Group');
    }
}
