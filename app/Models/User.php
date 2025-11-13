<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * These are include the users first_name,
     * last_name, email address and password
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * These include the users email address, password and administrator_flag
     * to ensure that other users cannot discover these attributes
     *
     * @var list<string>
     */
    protected $hidden = [
        'email',
        'password',
        'administrator_flag',
    ];

    public function posts()
    {
        return $this -> hasMany(Post::class);
    }

    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }
}
