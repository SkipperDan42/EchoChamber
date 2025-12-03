<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // States that there is a Factory to create instances of this Model
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'media',
        'heard',
        'echoed',
        'echoes',
        'claps'
    ];

    /**
     * Returns the post that this post echoed (reblogged))
     */
    public function getEchoedPostAttribute()
    {
        return Post::where('id', $this->echoed)
                ->first();
    }

    /**
     * Post belongs to a User
     */
    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    /**
     * Post has many comments
     */
    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }

    /**
     * Post has many claps
     */
    public function claps()
    {
        return $this->belongsToMany(User::class, 'post_claps')
            ->withTimestamps();
    }
}
