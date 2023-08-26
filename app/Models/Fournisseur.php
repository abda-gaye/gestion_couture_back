<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $guarded = [

    ];
    protected $hidden = [
        "created_at",
		"updated_at"
    ];
    public function articles()
{
    return $this->belongsToMany(Article::class, 'article_fournisseur');
}

public function article_fournisseur()
{
    return $this->hasMany(Article_Fournisseur::class);
}

}
