<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'price',
        'store_id',
    ];

    /**
     * Get the user that owns the store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
