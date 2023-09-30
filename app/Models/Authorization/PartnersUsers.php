<?php

namespace App\Models\Authorization;

use App\Models\ActionsProfils;
use App\Models\Modules;
use App\Models\Parteners;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $parteners_id
 * @property int $parteners_roles_id
 * @property int $first_connection
 * @property int $password_expired
 * @property int $password_duration_day
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $adress
 * @property string $password
 * @property Parteners $partner
 * @property PartnersRoles $partnerRole
 * @property string $name
 */
class PartnersUsers extends Model
{
    protected $table = 'parteners_users';
    protected $appends=['name'];
    public function name():Attribute{
        return Attribute::make(fn()=> $this->first_name . " " . $this->last_name );
    }
    /**
     * @var array
     */
    protected $guarded = ['id'];
    function partnerRole(): BelongsTo
    {
        return $this->belongsTo(PartnersRoles::class,'parteners_roles_id');
    }
    function partner(): BelongsTo
    {
        return $this->belongsTo(Parteners::class,'parteners_id');
    }

}
