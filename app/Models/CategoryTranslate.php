<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslate extends Model
{
    use HasFactory;
    protected $table = "category_translates";
    protected $fillable = ['name', 'language_id', 'product_category_id'];
    protected $casts = [
        'id'            => 'integer',
        'name'          => 'string',
        'product_category_id'    => 'integer',
        'language_id'    => 'integer',
    ];

    public function product_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Languages::class, 'language_id', 'id')->withTrashed();
    }

    public function languages()
    {
        return $this->belongsToMany(Languages::class, 'category_translates', 'product_category_id', 'language_id');
    }
}
