<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllResources;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\CategoriesResource;
use App\Models\Categorie;
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
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $categorie)
    {
        $input = $request->all();

        $validator = FacadesValidator::make($input, [
            'iduser' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Categories = Categorie::where('id','=',$categorie)->where('iduser','=',$input['iduser'])->get();

        if ($Categories->isEmpty()) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse(new AllResources($Categories), 'Categories retrieved successfully.');
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
