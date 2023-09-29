<?php

namespace App\Models;

use App\Models\Authorization\PartnersRoles;
use App\Models\Authorization\PartnersUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property float $solde
 * @property float $amount_reserved
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $adress
 * @property string $password
 * @property boolean $first_connection
 * @property string $password_expired
 * @property int $password_duration_day
 * @property Commission[] $commissions
 * @property OperationParteners[] $operationParteners
 * @property PartenerComptes[] $partenerComptes
 * @property PartenerSettings[] $partenerSettings
 * @property SousServicesParteners[] $sousServicesParteners
 * @property Transactions[] $transactions
 * @property Country $country
 * @property string $allow_id
 * @property PartnersUsers $users
 * @property PartnersRoles $partnersRoles
 */
class Parteners extends Model
{
    protected $appends=['user'];
    public PartnersUsers $user;
    /**
     * @var array
     */
    protected $fillable = ['allow_id','countries_id','created_at', 'updated_at', 'state', 'solde', 'amount_reserved', 'name', 'phone', 'email', 'adress', 'password', 'first_connection', 'password_expired', 'password_duration_day'];

    /**
     * @return HasMany
     */
    public function commissions()
    {
        return $this->hasMany('App\Models\Commissions', 'parteners_id');
    }

    /**
     * @return HasMany
     */
    public function operationParteners()
    {
        return $this->hasMany('App\Models\OperationParteners', 'parteners_id');
    }

    /**
     * @return HasMany
     */
    public function partenerComptes()
    {
        return $this->hasMany('App\Models\PartenerComptes', 'parteners_id');
    }

    /**
     * @return HasMany
     */
    public function partenerSettings()
    {
        return $this->hasMany('App\Models\PartenerSettings', 'parteners_id');
    }

    /**
     * @return HasMany
     */
    public function sousServicesParteners()
    {
        return $this->hasMany('App\Models\SousServicesParteners', 'parteners_id');
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions', 'parteners_id');
    }
    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countries_id');
    }
    function partnersRoles(): HasMany
    {
        return $this->hasMany(PartnersRoles::class,'parteners_id');
    }
    function users(): HasMany
    {
        return $this->hasMany(PartnersUsers::class,'parteners_id');
    }
}
