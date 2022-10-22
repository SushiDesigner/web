<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'creator_type',
        'content'
    ];

    /**
     * The creator of this status.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
