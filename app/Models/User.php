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

    /**
     * Returns the highest heard post (post with most views) by user
     */
    public function getTopHeardPostAttribute()
    {
        return $this->posts()
            ->orderBy('heard', 'desc')
            ->first();
    }

    /**
     * Returns the highest heard comment (comment with most views) by user
     */
    public function getTopHeardCommentAttribute()
    {
        return $this->comments()
            ->orderBy('heard', 'desc')
            ->first();
    }

    /**
     * Returns the highest clapped post (post with most likes) by user
     */
    public function getTopClappedPostAttribute()
    {
        return $this->posts()
            ->orderBy('claps', 'desc')
            ->first();
    }

    /**
     * Returns the highest clapped comment (comment with most likes) by user
     */
    public function getTopClappedCommentAttribute()
    {
        return $this->comments()
            ->orderBy('claps', 'desc')
            ->first();
    }

    /**
     * Returns the highest echoed post (post most reblogged) by user
     */
    public function getTopEchoedPostAttribute()
    {
        return $this->posts()
            ->orderBy('echoes', 'desc')
            ->first();
    }

    /**
     * User has many posts
     */
    public function posts()
    {
        return $this -> hasMany(Post::class);
    }

    /**
     * User has many comments
     */
    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }

    /**
     * User has clapped many posts
     */
    public function clappedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_claps')
            ->withTimestamps();
    }

    /**
     * User has clapped many comments
     */
    public function clappedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_claps')
            ->withTimestamps();
    }
}
