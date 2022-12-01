<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class uploadController extends BaseController
{
    public function upload()
    {
        for ($i=0; $i < count($_FILES['files']['name']); $i++) { 
            $target_dir = "menu/";

            $target_file = $target_dir.basename($_FILES['files']['name'][$i]);

            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {
                $data = array("data"=>"Image telechargé avec succès");
            }else{
                return $this->sendError('Creation error.', 'Erreur lors du chargment');
            }
        }
        
        return $this->sendResponse($data, 'Fichier chargé avec succès.');
    }
}
