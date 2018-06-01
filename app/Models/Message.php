<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'description' 
    ];

    /**
     * Get the contact that owns the message.
     */
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class);
    }
    
}
