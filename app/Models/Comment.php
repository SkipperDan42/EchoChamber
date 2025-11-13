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

    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    public function post()
    {
        return $this -> belongsTo(Post::class);
    }
}
