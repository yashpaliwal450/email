<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'age',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'password' => 'hashed',
    ];

    public function sentEmails()
    {
        return $this->hasMany(email::class, 'sender_id');
    }

    public function receivedEmails()
    {
        return $this->hasMany(email::class, 'recever_id');
    }

    public function cc()
    {
        return $this->hasMany(email::class, 'cc_id');
    }

    public function bcc()
    {
        return $this->hasMany(email::class, 'bcc_id');
    }
    
    public function photo()
    {
        return $this->hasOne(userphoto::class, 'user_id');
    }
}
