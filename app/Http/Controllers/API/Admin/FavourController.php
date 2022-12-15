<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllResources;
use App\Models\Favour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class FavourController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $plats = Favour::join('favours', 'plats.id', '=', 'favours.idplat')
            ->join('users', 'plats.iduser', '=', 'user.id')
            ->where('plats.id','=', $id)
            ->select('plats.*', 'users.id',  'users.name', 'users.email_verified_at')
            ->get();

        if ($plats) {
            return $this->sendResponse(new AllResources($plats), 'Menus recuperés avec succès.');
        } else {
            return $this->sendError("Vous n'avez pas de favoris", '$plats->errors()');
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
            'heure' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $favour = new Favour();

        $favour->iduser = $input['iduser'];
        $favour->idplat = $input['idplat'];
        $favour->heure = $input['heure'];
        $favour->date = $input['date'];
        $savefavour = $favour->save();

        if ($savefavour) {
            return $this->sendResponse(new AllResources($favour), 'Menu ajouté au panier avec succès.');
        } else {
            return $this->sendError('Creation error.', '$categorie->errors()');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favour  $favour
     * @return \Illuminate\Http\Response
     */
    public function show(Favour $favour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favour  $favour
     * @return \Illuminate\Http\Response
     */
    public function edit(Favour $favour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favour  $favour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favour $favour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favour  $favour
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plat = Favour::where('id', $id)->delete();

        if ($plat) {
            return $this->sendResponse([], 'Menu supprimé avec succès.');
        }else {
            return $this->sendError('Creation error.', '$plat->errors()');
        }
    }
}
