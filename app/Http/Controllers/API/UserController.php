<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllResources;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();

        if ($user->isEmpty()) {
            return $this->sendError('not user found', $user->errors());
        } else {
            return $this->sendResponse(AllResources::collection($user), 'user retrieved successfully.');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showAdmin($id)
    {
        $user = User::join('entreprises', 'users.id', '=', 'entreprises.iduser')
        ->where('users.id', '=', $id)
        ->select('users.*', 'entreprises.*')
        ->get();

        if ($user->isEmpty()) {
            return $this->sendError('Utilisateur inexistant.');
        }

        return $this->sendResponse(new AllResources($user), 'Connecté(e) avec succès.');
    }


    public function showUser($id)
    {
        $user = User::where('id', '=', $id)->get();

        if ($user->isEmpty()) {
            return $this->sendError('Utilisateur inexistant.');
        }

        if($user){
            return $this->sendResponse(new AllResources($user), 'Connecté(e) avec succès.');
        }else{
            return $this->sendError('Utilisateur inexistant.');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
