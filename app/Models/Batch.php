<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Batch extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'batchs';

    protected $fillable = ['name', 'event_id', 'slots', 'slots_available'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_user', 'batch_id', 'user_id');
    }
}
