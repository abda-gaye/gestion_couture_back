<?php

namespace App\Http\Resources;

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'prix' => $this->prix,
            'stock' => $this->stock,
            'fournisseurs_id' => $this->fournisseurs_id,
            'categories_id' => $this->categories_id,
            'REF' => $this->REF,
            'photo' => $this->photo,
            'categorie' => Categorie::find($this->categories_id),
            'fournisseur' => Fournisseur::find($this->fournisseurs_id),
        ];
    }
}
