<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    protected $guarded = [

    ];
    protected $hidden = [
        "created_at",
		"updated_at"
    ];
    public function fournisseurs()
{
    return $this->belongsToMany(Fournisseur::class, 'article_fournisseur');
}

public function fournisseur()
{
    return $this->belongsTo(Fournisseur::class);
}
public function article_fournisseur()
{
    return $this->hasMany(Article_Fournisseur::class);
}
}
