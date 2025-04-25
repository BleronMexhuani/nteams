<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Authors extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorsFactory> */
    use HasFactory;

    protected $casts = [
        'birthdate' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'biography',
        'birthdate',
    ];

    public function books()
    {
        return $this->hasMany(Books::class, 'author_id', 'id');
    }

    public function scopeSearch(Builder $query, ?string $searchTerm): Builder
    {
        if (!$searchTerm) {
            return $query;
        }

        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('biography', 'like', "%{$searchTerm}%");
        });
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        });
    }
}
