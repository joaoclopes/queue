<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'birth_date', 'email'];

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_user', 'user_id', 'batch_id');
    }
}
