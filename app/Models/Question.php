<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * Gets the association with options table.
     *
     * @return Option
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }


    /**
     * Get the user that created the question.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
