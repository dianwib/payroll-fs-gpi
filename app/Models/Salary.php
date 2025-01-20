<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\IsDeleteScope;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Salary extends Model
{
    use HasFactory, HasUlids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'department_id',
        'basic_salary',
        'meal_allowances',
        'transport_allowances',
        'position_allowances',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employeSalaries()
    {
        return $this->hasMany(EmployeSalary::class);
    }

    public function setMealAllowancesAttribute($value)
    {
        // Menghapus 'Rp', spasi, dan titik, lalu konversi ke integer
        $this->attributes['meal_allowances'] = (int) str_replace(['Rp', ' ', '.'], '', $value);
    }

    public function setPositionAllowancesAttribute($value)
    {
        // Menghapus 'Rp', spasi, dan titik, lalu konversi ke integer
        $this->attributes['position_allowances'] = (int) str_replace(['Rp', ' ', '.'], '', $value);
    }

    public function setTransportAllowancesAttribute($value)
    {
        // Menghapus 'Rp', spasi, dan titik, lalu konversi ke integer
        $this->attributes['transport_allowances'] = (int) str_replace(['Rp', ' ', '.'], '', $value);
    }

    public function setBasicSalaryAttribute($value)
    {
        // Menghapus 'Rp', spasi, dan titik, lalu konversi ke integer
        $this->attributes['basic_salary'] = (int) str_replace(['Rp', ' ', '.'], '', $value);
    }

    protected $casts = [
        'basic_salary' => 'integer',
        'meal_allowances' => 'integer',
        'position_allowances' => 'integer',
        'transport_allowances' => 'integer',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new IsDeleteScope);
    }
}
