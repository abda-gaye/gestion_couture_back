<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'categorie_id', 'promo', 'promo_value', 'price', 'reference', 'photo', 'margin'
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
}
