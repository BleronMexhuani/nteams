<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Books extends Model
{
    /** @use HasFactory<\Database\Factories\BooksFactory> */
    use HasFactory;
    protected $fillable = [
        'author_id',
        'title',
        'isbn',
        'description',
        'published_date',
        'cover_url',
    ];
    protected $casts = [
        'published_date' => 'date',
    ];

    public function scopeSearch(Builder $query, ?string $searchTerm): Builder
    {
        if (!$searchTerm) {
            return $query;
        }

        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('isbn', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhereHas('author', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                });
        });
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        })
            ->when($filters['author'] ?? null, function ($query, $authorId) {
                $query->where('author_id', $authorId);
            })
            ->when($filters['year'] ?? null, function ($query, $year) {
                $query->whereYear('published_date', $year);
            });
    }

    public function author()
    {
        return $this->belongsTo(Authors::class);
    }
}
