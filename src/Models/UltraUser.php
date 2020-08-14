<?php

namespace Amyisme13\UltraHelper\Models;

use Illuminate\Database\Eloquent\Model;

class UltraUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'moodle_id',
        'username',
        'email',
        'name',
        'function',
        'division',
        'position',
        'area',
        'sub_area',
        'costcenter',
        'top_username',
        'activated_at',
        'suspended',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'activated_at' => 'datetime',
        'suspended' => 'boolean',
    ];
}
