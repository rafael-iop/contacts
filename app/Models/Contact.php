<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'last_name', 
        'email', 
        'phone',
    ];

    /**
     * Get contact messages.
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    /**
     * Get contact full name.
     * 
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    /**
     * Generates an avatar url based in contact email (Gravatar) or full name (UI Avatars).
     * 
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return gravatar_or_fallback($this->email, $this->full_name);
    }

}
