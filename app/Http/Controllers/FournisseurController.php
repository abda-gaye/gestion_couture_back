<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->jsonResponse("200","",Fournisseur::all());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "prenom" => "required",
            "telephone" => ["required","regex:/^(77|76|78|70|75)[0-9]{7}$/","unique:fournisseurs"

            ]
        ]);
        if ($validator->fails()) {
            return response()->json([
                "statu" => 422,
                "message" => $validator->messages(),
                "data" => []
            ],422);
        }
        else{
            $categorie = Fournisseur::create([
                "prenom" => $request->prenom,
                "telephone" => $request->telephone
            ]);
        }
        if ($categorie) {
            return response()->json([
                "statu" => 201,
                "message" => "fournisseur crée avec succés",
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function searchByFirstName($prenom)
    {
        $fournisseurs = Fournisseur::where('prenom', 'like', '%' . $prenom . '%')
            ->get();
                return response()->json([
                    "status" => 200,
                    "message" => "fournisseur trouvé",
                    "data" => [$fournisseurs]
                ], 200);
            }
       
}
