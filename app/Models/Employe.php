<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\IsDeleteScope;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employe extends Model
{
    use HasFactory, HasUlids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'department_id',
        'join_date',
        'employe_type_id',
        'is_active',
    ];

    public function employeType()
    {
        return $this->belongsTo(EmployeType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function jobHistories()
    {
        return $this->hasMany(JobHistory::class);
    }

    public function licenseHistories()
    {
        return $this->hasMany(LicenseHistory::class);
    }

    public function certificateHistories()
    {
        return $this->hasMany(CertificateHistory::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new IsDeleteScope);
    }
}
