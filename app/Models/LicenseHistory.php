<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\IsDeleteScope;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class LicenseHistory extends Model
{
    use HasFactory, Notifiable, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employe_id',
        'applicant_id',
        'name',
        'start_date',
        'end_date',
        'remarks',
        'is_active',
    ];

    public function employe()
    {
        return $this->hasOne(Employe::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
        static::addGlobalScope(new IsDeleteScope());
    }
}
