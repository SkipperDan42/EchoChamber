<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // States that there is a Factory to create instances of this Model
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'content',
        'heard',
        'claps'
    ];

    /**
     * Comment belongs to a User
     */
    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    /**
     * Comment belongs to a Post
     */
    public function post()
    {
        return $this -> belongsTo(Post::class);
    }

    /**
     * Comment has many claps
     */
    public function claps()
    {
        return $this->belongsToMany(User::class, 'comment_claps')
            ->withTimestamps();
    }
}
