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

    // ---------------------------------
    // --------- RELATIONSHIPS ---------
    // ---------------------------------

    /**
     * Get contact messages.
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    // ---------------------------------
    // ------------ MUTATORS -----------
    // ---------------------------------

    /**
     * Get contact's full name.
     * 
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Generates an avatar url based in contact's email (Gravatar) or full name (UI Avatars).
     * 
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return gravatar_or_fallback($this->email, $this->full_name);
    }

    /**
     * Converts contact's email to lowercase.
     * 
     * @param string $email
     * @return void
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    // ---------------------------------
    // ------------- SEARCH ------------
    // ---------------------------------

    /**
     * Search contacts based on request attributes.
     * Only search if searchText is filled.
     * 
     * @param  $query
     * @param  Illuminate\Http\Request $request
     * @return $query
     */
    public function scopeSearch($query, $request)
    {
        if (! $searchText = $request->search) {
            return $query;
        }

        return $query->where(function($query) use ($searchText) {
            $query->where(function($query) use ($searchText) {
                $query->searchByName($searchText);
            });

            $query->orWhere(function($query) use ($searchText) {
                $query->searchByEmail($searchText);
            });

            $query->orWhere(function($query) use ($searchText) {
                $query->searchByPhone($searchText);
            });
        });
    }

    /**
     * Search contacts by name or last name.
     * 
     * @param  $query
     * @param  string $name
     * @return $query
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where(function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
            $query->orWhere('last_name', 'like', '%' . $name . '%');
        });
    }

    /**
     * Search contacts by email.
     * 
     * @param  $query
     * @param  string $email
     * @return $query
     */
    public function scopeSearchByEmail($query, $email)
    {
        return $query->where('email', 'like', '%' . $email . '%');
    }

    /**
     * Search contacts by phone number.
     * 
     * @param  $query
     * @param  string $phone
     * @return $query
     */
    public function scopeSearchByPhone($query, $phone)
    {
        return $query->where('phone', 'like', '%' . $phone . '%');
    }

    // ---------------------------------
    // ------------- ORDER -------------
    // ---------------------------------

    /**
     * Order contacts by full name.
     * 
     * @param  $query
     * @param  string $orderDirection
     * @return $query
     */
    public function scopeOrderByFullName($query, $orderDirection)
    {
        return $query->orderBy('name', $orderDirection)
                    ->orderBy('last_name', $orderDirection);
    }

}
