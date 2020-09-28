<?php

namespace App\Models;

use App\Models\Answear;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Gets the association with votes table.
     *
     * @return Vote
     */
    public function vote ()
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * Let a user vote a an option that belogs to a question.
     *
     * @return Vote
     */
    public function voteOn ($option)
    {
        $user_id = auth()->user()->id;

        // dont let the user vote twise
        return $option->votes()->updateOrCreate(
            ['user_id' => $user_id],
            ['option_id' => $option->id]
        );
    }
}
