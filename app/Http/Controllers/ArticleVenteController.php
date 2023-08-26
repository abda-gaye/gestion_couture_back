<?php

namespace App\Http\Controllers;

use App\Models\ArticleVente;
use Illuminate\Http\Request;

class ArticleVenteController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'categorie_id' => 'required',
            'promo' => 'nullable|boolean',
            'promo_value' => 'nullable|numeric',
            'price' => 'required|numeric',
            'reference' => 'nullable',
            'photo' => 'required',
            'margin' => 'required|numeric',
        ]);

        return ArticleVente::create($validatedData);
    }

    public function update(Request $request, $id)
{

    $validatedData = $request->validate([
        'name' => 'required',
        'categorie_id' => 'required',
        'promo' => 'nullable|boolean',
        'promo_value' => 'nullable|numeric',
        'price' => 'required|numeric',
        'reference' => 'nullable',
        'photo' => 'required',
        'margin' => 'required|numeric',
    ]);


    $article = ArticleVente::findOrFail($id);

    $article->update($validatedData);

    return response()->json(['message' => 'Article de vente mis à jour avec succès.']);
}

public function destroy($id)
{
    $article = ArticleVente::findOrFail($id);

    $article->delete();

    return response()->json(['message' => 'Article de vente supprimé avec succès.']);
}
public function search(Request $request)
{
    $query = $request->input('query');

    $articles = ArticleVente::where('name', 'like', '%' . $query . '%')->get();

    return response()->json(['articles' => $articles]);
}

}
