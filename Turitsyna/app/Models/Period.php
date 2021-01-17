<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Period
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    use HasFactory;
    protected $table = 'period';
    protected $primaryKey = 'id';
}
