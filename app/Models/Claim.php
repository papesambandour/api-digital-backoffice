<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $subject
 * @property string $state
 * @property string $claim_ref
 * @property string $message
 * @property string $comment
 * @property string $callback_url
 * @property string $statut
 * @property string $parteners_id
 * @property string $user_id_open
 * @property string $user_id_close
 * @property string $user_id_comment
 * @property string $transaction_id
 * @property string $created_at
 * @property string $updated_at
 * @property Transactions $transaction
 */
class Claim extends Model
{
    protected $table= 'claim';
    public function transaction():Attribute{
        return Attribute::make(fn()=> Transactions::find($this->transaction_id));
    }
    /**
     * @var array
     */
    protected $fillable = ['subject', 'state', 'created_at', 'updated_at', 'claim_ref', 'message', 'comment', 'callback_url', 'statut','parteners_id','user_id_open','user_id_close','user_id_comment','transaction_id'];
}
