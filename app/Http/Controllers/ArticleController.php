<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_Fournisseur;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'libelle' => 'required|string|unique:articles',
            'prix' => 'required|integer',
            'stock' => 'required|integer',
            'fournisseurs_id' => 'required|array',
            'categories_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image',
        ]);

        $categories_id = $validatedData['categories_id'];
        $count = Article::where('categories_id', $categories_id)->count() + 1;

        $categorie = Categorie::where('id', $categories_id)->first();
        $libelle = strtoupper(substr($validatedData['libelle'], 0, 3));
        $ref = "REF-$libelle-$categorie->libelle-$count";

        $article = new Article([
            'libelle' => $validatedData['libelle'],
            'prix' => $validatedData['prix'],
            'stock' => $validatedData['stock'],
            'categories_id' => $categories_id,
            'REF' => $ref,
        ]);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('article_photos', 'public');
            $article->photo = $photoPath;
        }

        $article->save();

        DB::beginTransaction();
        try {
            $tabfournisseurs = $request['fournisseurs_id'];
            foreach ($tabfournisseurs as $fournisseur_id) {
                $f_id = new Article_Fournisseur([
                    'article_id' => $article->id,
                    'fournisseur_id' => $fournisseur_id
                ]);
                $f_id->save();
            }
            DB::commit();
            return $this->jsonResponse("201", "Article créé avec succès", $request->all());
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3);

        $articles = Article::join('categories', 'articles.categories_id', '=', 'categories.id')
            ->leftJoin('article_fournisseur', 'articles.id', '=', 'article_fournisseur.article_id')
            ->leftJoin('fournisseurs', 'article_fournisseur.fournisseur_id', '=', 'fournisseurs.id')
            ->select('articles.*', 'categories.libelle as categorie_libelle', 'fournisseurs.prenom as fournisseur_prenom')
            ->paginate($perPage);

        return $this->jsonResponse("200", "liste des articles", $articles);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return $this->jsonResponse('200', 'Article supprimé avec success', $article);
    }

    public function show($id)
    {
        $article = Article::with(['fournisseur', 'categorie', 'article_fournisseur'])->findOrFail($id);
        return $this->jsonResponse("200", "Détails de l'article récupérés avec succès", $article);
    }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'libelle' => 'required|string|unique:articles,libelle,' . $id,
        'prix' => 'required|integer',
        'stock' => 'required|integer',
        'fournisseurs_id' => 'required|array',
        'categories_id' => 'required|exists:categories,id',
        'photo' => 'nullable|image',
    ]);

    $article = Article::findOrFail($id);

    $article->update([
        'libelle' => $validatedData['libelle'],
        'prix' => $validatedData['prix'],
        'stock' => $validatedData['stock'],
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('article_photos', 'public');
        $article->update(['photo' => $photoPath]);
    }

    $article->fournisseurs()->sync($validatedData['fournisseurs_id']);

    return $this->jsonResponse("200", "Article mis à jour avec succès", $article);
}

}
