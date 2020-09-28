<?php

namespace App\Models;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'name'
    ];

    /**
     * Gets the association with votes table.
     *
     * @return Vote
     */
    public function votes ()
    {
        return $this->hasMany(Vote::class);
    }
}
