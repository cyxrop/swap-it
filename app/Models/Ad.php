<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    /**
     * Get the user that owns the ad.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get ad comments.
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Get ad photos.
     */
    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Photo');
    }

    /**
     * Return true if ad owner is current user
     * @return bool
     */
    public function checkOwnerIsCurrentUser()
    {
        return Auth::id() == $this->user->id;
    }
}
