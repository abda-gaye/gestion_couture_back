<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allCategories(){
        return Categorie::all();
    }
    public function index()
    {
       return Categorie::paginate(3);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "libelle" => "required|min:3|unique:categories",
            "type" => "required|in:confection,ventes",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "statu" => 422,
                "message" => $validator->messages(),
                "data" => []
            ],422);
        }

        else{
            $categorie = Categorie::create([
                "libelle" => $request->libelle,
                "type" => $request->type
            ]);
        }

        if ($categorie) {
            return response()->json([
                "statu" => 201,
                "message" => "categorie crée avec succés",
                "data" => $request->all()

            ],201);
        }
        else {
            return response()->json([
                "statu" => 500,
                "message" => "quelque chose a mal fonctionné",
                "data" => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            "libelle" => "required|min:3|unique:categories|string",
            "type" => "required|in:confection,ventes",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "statu" => 422,
                "message" => $validator->messages(),
                "data" => []
            ],422);
        }
        else{
            $categorie = Categorie::find($id);
            $categorie->update([
                "libelle" => $request->libelle,
                "type" => $request->type
            ]);
        }
        if ($categorie) {
            return response()->json([
                "statu" => 201,
                "message" => "categorie modifié avec succés",
                "data" => $request->all()

            ],201);
        }
        else {
            return response()->json([
                "statu" => 404,
                "message" => "categorie introuvable",
                "data" => []

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie  = Categorie::find($id);
        if ($categorie) {
            $categorie->delete();
        }

        else{
            return response()->json([
                "statu" => 404,
                "message" => "categorie introuvable",
                "data" => []

            ]);
        }

    }
    public function supprimer(Request $request){
        $idsupp = [];
        $ids = $request->ids;
        for ($i=0; $i < count($ids); $i++) {
            $categorie_ids = Categorie::find($ids[$i]);
            if ($categorie_ids) {
                array_push($idsupp,$categorie_ids);
            }
        }
            if (!empty($idsupp)) {
                for ($j=0; $j < count($idsupp) ; $j++) {
                    $idsupp[$j]->delete();
                    return response()->json([
                        "statu" => 404,
                        "message" => "categorie supprimé avec succes",
                        "data" => $idsupp

                    ]);
                }
            }
            else {
                return response()->json([
                    "statu" => 404,
                    "message" => "categorie introuvable",
                    "data" => []

                ]);
            }
    }
    public function searchCategory(Request $request)
    {
        $libelle = $request->libelle;
        if (strlen($libelle) < 3) {
            return response()->json([
                "statu" => 404,
                "message" => false,
                "data" => []

            ]);
        }
       else {
        $categorie = Categorie::where("libelle",$libelle)->first();
        if ($categorie) {
            return response()->json([
                "statu" => 404,
                "message" => false,
                "data" => []
            ]);
        }
        else{
            return response()->json([
                "statu" => 404,
                "message" => true,
                "data" => []

            ]);
        }
       }

    }
}
