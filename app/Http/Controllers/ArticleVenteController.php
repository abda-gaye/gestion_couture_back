<?php

namespace App\Http\Controllers;

use App\Models\ArticleVente;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ArticleVenteController extends Controller
{
    public function index(Request $request)
{
    $categories = Categorie::all();
    $articlesVentes = ArticleVente::paginate(2);

    return response()->json([
        'success' => true,
        'message' => 'Liste des catégories et des articles de vente.',
        'response' => [
            'categories' => $categories,
            'articles_ventes' => [
                'current_page' => $articlesVentes->currentPage(),
                'data' => $articlesVentes->items(),
                'first_page_url' => $articlesVentes->url(1),
                'from' => $articlesVentes->firstItem(),
                'last_page' => $articlesVentes->lastPage(),
                'last_page_url' => $articlesVentes->url($articlesVentes->lastPage()),
                'links' => $articlesVentes->links(),
                'next_page_url' => $articlesVentes->nextPageUrl(),
                'path' => $articlesVentes->path(),
                'per_page' => $articlesVentes->perPage(),
                'prev_page_url' => $articlesVentes->previousPageUrl(),
                'to' => $articlesVentes->lastItem(),
                'total' => $articlesVentes->total(),
            ],
        ],
    ]);
}

    

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

    $article = ArticleVente::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'Article de vente ajouté avec succès.',
        'response' => $article,
    ]);
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

    return response()->json([
        'success' => true,
        'message' => 'Article de vente mis à jour avec succès.',
        'response' => $article,
    ]);
}


public function destroy($id)
{
    $article = ArticleVente::findOrFail($id);
    $deletedArticle = $article->toArray(); 
    $article->delete();

    return response()->json([
        'success' => true,
        'message' => 'Article de vente supprimé avec succès.',
        'response' => $deletedArticle,
    ]);
}

public function search(Request $request)
{
    $query = $request->input('query');

    $articles = ArticleVente::where('name', 'like', '%' . $query . '%')->get();

    return response()->json([
        'success' => true,
        'message' => 'Résultats de la recherche.',
        'response' => ['articles' => $articles],
    ]);
}


}
