<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'user_id', 'rating', 'rated_by'
    ];

    /**
     * Return the owner of the rating
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the user who rated another user
     * 
     * @return App\User
     */
    public function ratedBy()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }
}
