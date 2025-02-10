<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'slug',
        'description',
        'icon',
        'product_count',
        'status',
        'collection_id',
        'parent_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
    ];

    /**
     * Get all products belonging to the category.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the direct children categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all descendants (children and their children).
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Get all categories in tree structure.
     */
    public static function getTree()
    {
        return self::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get active categories in tree structure.
     */
    public static function getActiveTree()
    {
        return self::query()
            ->with(['childrenRecursive' => function($query) {
                $query->where('status', 1);
            }])
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('name')
            ->get();
    }

    /**
     * Convert the category and its children to an array structure.
     */
    public function toTreeArray()
    {
        $node = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'status' => $this->status,
            'collection_id' => $this->collection_id,
            'children' => []
        ];

        foreach ($this->childrenRecursive as $child) {
            $node['children'][] = $child->toTreeArray();
        }

        return $node;
    }
}