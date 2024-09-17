<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'slots', 'slots_available'];

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'event_id');
    }
}
