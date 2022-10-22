<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'priority',
        'color',
        'superadmins_only'
    ];

    /**
     * The threads that belong to this category.
     */
    public function threads()
    {
        return $this->hasMany(ForumThread::class, 'category_id');
    }

    /**
     * The threads that belong to this category.
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'category_id');
    }
}
