<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $fillable = [
        "sender_id",
        "recevier_id",
        "message",
    ];

    /**
    * @return BelongsTo
    */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @return BelongsTo
    */
    public function recevier(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
