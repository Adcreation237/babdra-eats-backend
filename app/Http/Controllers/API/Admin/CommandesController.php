<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\AllResources;
use App\Models\Livraison;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CommandesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $commandes = Commande::join('plats', 'commandes.idplat', '=', 'plats.id')
            ->join('users', 'commandes.iduser', '=', 'users.id')
            ->where('commandes.idresto', '=', $id)
            ->where('commandes.statut', '!=', 'annulee')
            ->select('commandes.*', 'plats.img_link', 'plats.nameplats', 'plats.prix', 'users.name')
            ->get();

        if ($commandes->isEmpty()) {
            return $this->sendError("Vous n'avez pas de commandes", '$commandes->errors()');
        } else {
            return $this->sendResponse(AllResources::collection($commandes), 'Commandes recuperées avec succès.');
        }
    }

    public function comClient($id, $name)
    {
        $commandes = Commande::join('plats', 'commandes.idplat', '=', 'plats.id')
            ->join('users', 'commandes.iduser', '=', 'users.id')
            ->where('commandes.iduser', '=', $id)
            ->where('commandes.statut', '=', $name)
            ->select('commandes.*', 'plats.img_link', 'plats.nameplats', 'plats.prix', 'users.name')
            ->get();

        if ($commandes->isEmpty()) {
            return $this->sendError("Vous n'avez pas de commandes", '$commandes->errors()');
        } else {
            return $this->sendResponse(AllResources::collection($commandes), 'Commandes recuperées avec succès.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'iduser' => 'required',
            'idplat' => 'required',
            'idresto' => 'required',
            'qte' => 'required',
            'statut' => 'required',
            'date' => 'required',
            'heure' => 'required',
            'position' => 'required',
            'long' => 'required',
            'lat' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $Command = new Commande();

        $Command->iduser = $input['iduser'];
        $Command->idplat = $input['idplat'];
        $Command->idresto = $input['idresto'];
        $Command->qte = $input['qte'];
        $Command->statut = $input['statut'];
        $Command->heure = $input['heure'];
        $Command->date = $input['date'];
        $Command->position = $input['position'];
        $Command->long = $input['long'];
        $Command->lat = $input['lat'];
        $saveCommand = $Command->save();

        if ($saveCommand) {
            return $this->sendResponse(new AllResources($Command), 'Menu ajouté au panier avec succès.');
        } else {
            return $this->sendError('Creation error.', '$categorie->errors()');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $statut, $prix)
    {
        if ($statut == 'traitee') {
            $Comm = Commande::where('id', '=', $id)->get();
            $iduser = $idresto = $plats = $amount = $position = $long = $lat = '';

            foreach ($Comm as $key) {
                $iduser = $key['iduser'];
                $idresto = $key['idresto'];
                $plats = $key['idplat'];
                $amount = intval($key['qte']) * intval($prix) + 1500;
                $position = $key['position'];
                $long = $key['long'];
                $lat = $key['lat'];
            }

            $pieces = explode(" ", $prix);

            $Livraison = new Livraison();

            $Livraison->iduser = $iduser;
            $Livraison->idresto = $idresto;
            $Livraison->plats = $plats;
            $Livraison->amount = $amount.''.$pieces[1];
            $Livraison->position = $position;
            $Livraison->long = $long;
            $Livraison->lat = $lat;
            $saveLivraison = $Livraison->save();

            if ($saveLivraison) {

                $commande = Commande::where('id', $id)
                ->update(['statut' => $statut]);
                return $this->sendResponse([], 'Opération effectuée avec succès.');
            } else {
                return $this->sendError('Opération error.', '$commande->errors()');
            }
        }else{
            $commande = Commande::where('id', $id)
            ->update(['statut' => $statut]);
            if ($commande) {
                return $this->sendResponse([], 'Opération effectuée avec succès.');
            } else {
                return $this->sendError('Opération error.', '$commande->errors()');
            }
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
