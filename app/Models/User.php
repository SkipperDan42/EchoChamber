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
        'username',
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

    /**
     * Ensures that any email entered, whether in Registration, Update or Login
     * is correctly trimmed and set to lower-case
     *
     * @var String value    - the email to be correctly set
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim(strtolower($value));
    }

    public function getTopHeardPostAttribute()
    {
        return $this->posts()
            ->orderBy('heard', 'desc')
            ->first();
    }

    public function getTopHeardCommentAttribute()
    {
        return $this->comments()
            ->orderBy('heard', 'desc')
            ->first();
    }

    public function getTopClappedPostAttribute()
    {
        return $this->posts()
            ->orderBy('claps', 'desc')
            ->first();
    }

    public function getTopClappedCommentAttribute()
    {
        return $this->comments()
            ->orderBy('claps', 'desc')
            ->first();
    }

    public function getTopEchoedPostAttribute()
    {
        return $this->posts()
            ->orderBy('echoes', 'desc')
            ->first();
    }

    public function posts()
    {
        return $this -> hasMany(Post::class);
    }

    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }

    public function clappedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_claps')
            ->withTimestamps();
    }

    public function clappedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_claps')
            ->withTimestamps();
    }
}
