<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    use HasFactory;
    protected $table = "product_attribute_options";
    protected $fillable = ['product_attribute_id', 'name', 'name_et', 'name_ru'];
    protected $casts = [
        'id'                   => 'integer',
        'product_attribute_id' => 'integer',
        'name'                 => 'string',
        'name_et'   => 'string',
        'name_ru'   => 'string',
    ];
}