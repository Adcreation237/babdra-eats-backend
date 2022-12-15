<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllResources;
use App\Http\Resources\PanierResource;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PanierController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $paniers = Panier::join('plats', 'paniers.idplat', '=', 'plats.id')
            ->join('users', 'paniers.iduser', '=', 'users.id')
            ->where('users.id','=', $id)
            ->select('paniers.*', 'plats.*')
            ->get();

        if (!$paniers) {
            return $this->sendError('not paniers found', 'paniers pas trouvées');
        } else {
            return $this->sendResponse(new AllResources($paniers), 'paniers retrieved successfully.');
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
            'date' => 'required',
            'heure' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $panier = new Panier();

        $panier->iduser = $input['iduser'];
        $panier->idplat = $input['idplat'];
        $panier->date = $input['date'];
        $panier->heure = $input['heure'];
        $savepanier = $panier->save();

        if ($savepanier) {
            return $this->sendResponse(new PanierResource($panier), 'Menu ajouté au panier avec succès.');
        } else {
            return $this->sendError('Creation error.', '$categorie->errors()');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function show(Panier $panier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function edit(Panier $panier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plat = Panier::where('id', $id)->delete();

        if ($plat) {
            return $this->sendResponse([], 'Menu supprimé avec succès.');
        }else {
            return $this->sendError('Creation error.', '$plat->errors()');
        }
    }
}
