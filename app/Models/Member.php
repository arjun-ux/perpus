<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;
    protected $guarded;


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function kelas():BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'class_id', 'id');
    }

    public function borrow(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
