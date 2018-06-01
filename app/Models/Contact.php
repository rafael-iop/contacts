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

}
