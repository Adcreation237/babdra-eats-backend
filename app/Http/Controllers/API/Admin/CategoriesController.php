<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllResources;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\CategoriesResource;
use App\Models\Categorie;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CategoriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::get();

        if ($categories->isEmpty()) {
            return $this->sendError('not categories found', '$categories->errors()');
        } else {
            return $this->sendResponse(CategoriesResource::collection($categories), 'categories retrieved successfully.');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $categories = Categorie::limit(4)->get();

        if (!$categories) {
            return $this->sendError('not categories found', 'categories pas trouvées');
        } else {
            return $this->sendResponse(CategoriesResource::collection($categories), 'categories retrieved successfully.');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function showCat($id)
    {
        $categories = Categorie::join('plats', 'categories.id', '=', 'plats.idCat')
            ->join('users', 'plats.iduser', '=', 'users.id')
            ->where('categories.id','=', $id)
            ->where('plats.posted','!=', '0')
            ->select('plats.*', 'categories.namecat', 'users.id', 'users.name', 'users.email_verified_at')
            ->get();

        if (!$categories) {
            return $this->sendError('not categories found', 'categories pas trouvées');
        } else {
            return $this->sendResponse(new AllResources($categories), 'plats categories retrieved successfully.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'iduser' => 'required',
            'name' => 'required',
            'link_img' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $categorie = Categorie::create($input);

        return $this->sendResponse(new CategoriesResource($categorie), 'Category created successfully.');
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = FacadesValidator::make($request->all(), [
            'namecat' => 'required',
            'link_img' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $categorie = new Categorie();

        $categorie->namecat = $input['namecat'];
        $categorie->link_img = $input['link_img'];
        $saveCategorie = $categorie->save();

        if ($saveCategorie) {
            return $this->sendResponse(new CategoriesResource($categorie), 'Catégotie créée avec succès.');
        } else {
            return $this->sendError('Creation error.', '$categorie->errors()');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {

        $input = $request->all();

        $validator = FacadesValidator::make($input, [
            'name' => 'required',
            'link_img' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $categorie->name = $input['name'];
        $categorie->detail = $input['detail'];
        $categorie->save();

        return $this->sendResponse(new CategoriesResource($categorie), 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return $this->sendResponse([], 'Category deleted successfully.');
    }
}
