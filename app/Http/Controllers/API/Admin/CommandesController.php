<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CommandesResource;
use App\Http\Resources\AllResources;
use App\Models\Livraison;

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
        //
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
