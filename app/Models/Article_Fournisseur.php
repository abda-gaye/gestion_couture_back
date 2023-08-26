<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_Fournisseur extends Model
{
    use HasFactory;

    protected $guarded = [

    ];
    protected $hidden = [
        "created_at",
		"updated_at"
    ];

    public $table = 'article_fournisseur';
}
