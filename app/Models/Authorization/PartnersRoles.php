<?php

namespace App\Models\Authorization;

use App\Models\ActionsProfils;
use App\Models\Modules;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $modules_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $code
 * @property string $method
 * @property string $url
 * @property string $icon
 * @property Modules $module
 * @property ActionsProfils[] $actionsProfils
 */
class PartnersRoles extends Model
{
    protected $table = 'parteners_roles';
    /**
     * @var array
     */
    protected $guarded = ['id'];

}
