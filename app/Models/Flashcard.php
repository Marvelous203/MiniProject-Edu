<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flashcard extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'flashcard_set_id',
        'question',
        'answer',
        'note',
    ];

    public function flashcardSet(): BelongsTo
    {
        return $this->belongsTo(FlashcardSet::class);
    }

    public function sessionResults(): HasMany
    {
        return $this->hasMany(SessionResult::class);
    }
}
