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

    /**
     * Scope a query to only containing the given keyword
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($query) use ($keyword) {
            $query
                ->where('name', 'like', "%$keyword%")
                ->orWhere('username', 'like', "%$keyword%");
        });
    }

    /**
     * Scope a query to only include the given division
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param string $division
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDivision($query, $division)
    {
        if (empty($division)) {
            return $query;
        }

        return $query->where('division', $division);
    }
}
