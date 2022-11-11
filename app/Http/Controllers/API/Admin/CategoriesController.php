<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $categories = Categorie::where('iduser','=',$id)->get();

        if ($categories->isEmpty()) {
            return $this->sendError('not categories found', $categories->errors());
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show($iduser, $id)
    {
        $Categories = Categorie::where('id','=',$id)->where('iduser','=',$iduser)->get();

        if (is_null($Categories)) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse(new CategoriesResource($Categories), 'Categories retrieved successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //
    }
}
