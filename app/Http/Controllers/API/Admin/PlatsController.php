<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlatsResource;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\AllResources;

class PlatsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $plats = Plat::where('iduser','=', $id)->get();

        if ($plats->isEmpty()) {
            return $this->sendError("Vous n'avez pas de menu",' $plats->errors()');
        } else {
            return $this->sendResponse(PlatsResource::collection($plats), 'Menus recuperés avec succès.');
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

        $input = $request->all();

        $validator = Validator::make($input, [
            'iduser' => 'required',
            "idCat" => 'required',
            "img_link" => 'required',
            "nameplats" => 'required',
            "prix" => 'required',
            "ingredients" => 'required',
            "description" => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $plats = Plat::create($input);
        if ($plats) {
            return $this->sendResponse(new PlatsResource($plats), 'Menu ajouté avec succès.');
        } else {
            return $this->sendError('Creation error.',' $plats->errors()');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plat  $plat
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $plats = Plat::join('users', 'plats.iduser', '=', 'users.id')
            ->join('categories', 'plats.idCat', '=', 'categories.id')
            ->where('plats.posted','!=', '0')
            ->select('plats.*', 'categories.namecat', 'users.id',  'users.name', 'users.email_verified_at')
            ->get();

        if ($plats) {
            return $this->sendResponse(new AllResources($plats), 'Menus recuperés avec succès.');
        } else {
            return $this->sendError("Vous n'avez pas de menu",' $plats->errors()');
        }
    }

    public function showPlat($id)
    {

        $plats = Plat::join('users', 'plats.iduser', '=', 'users.id')
            ->join('categories', 'plats.idCat', '=', 'categories.id')
            ->where('plats.id','=', $id)
            ->select('plats.*', 'categories.namecat', 'users.id',  'users.name', 'users.email_verified_at')
            ->get();

        if ($plats) {
            return $this->sendResponse(new AllResources($plats), 'Menus recuperés avec succès.');
        } else {
            return $this->sendError("Vous n'avez pas de menu",' $plats->errors()');
        }
    }


    public function searchPlat($colum, $name)
    {

        $plats = Plat::join('users', 'plats.iduser', '=', 'users.id')
            ->join('categories', 'plats.idCat', '=', 'categories.id')
            ->where($colum,'like', '%'.$name.'%')
            ->where('plats.posted','!=', '0')
            ->select('plats.*', 'categories.namecat', 'users.id',  'users.name', 'users.email_verified_at')
            ->get();

        if ($plats) {
            return $this->sendResponse(new AllResources($plats), 'Menus recuperés avec succès.');
        } else {
            return $this->sendError("Vous n'avez pas de menu",' $plats->errors()');
        }
    }

    public function showPub()
    {

        $plats = Plat::join('users', 'plats.iduser', '=', 'users.id')
            ->join('categories', 'plats.idCat', '=', 'categories.id')
            ->where('plats.posted','=', '2')
            ->select('plats.*', 'categories.namecat', 'users.id', 'users.name', 'users.email_verified_at')
            ->get();

        if ($plats) {
            return $this->sendResponse(PlatsResource::collection($plats), 'Menus recuperés avec succès.');
        } else {
            return $this->sendError("Vous n'avez pas de menu",' $plats->errors()');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plat  $plat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plat = Plat::where('id', $id)
                        ->update(['posted' => true]);;

        if ($plat) {
            return $this->sendResponse([], 'Menu publié avec succès.');
        }else {
            return $this->sendError('Creation error.', '$plat->errors()');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plat  $plat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plat $plat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plat  $plat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plat = Plat::where('id', $id)->delete();

        if ($plat) {
            return $this->sendResponse([], 'Menu supprimé avec succès.');
        }else {
            return $this->sendError('Creation error.', '$plat->errors()');
        }
    }
}
