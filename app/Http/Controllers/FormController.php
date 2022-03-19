<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormColumn;
class FormController extends Controller
{
    public function fetchFormById($id){
        #id is form_id
        // return "Hit in fetchFormById with parameter $id";
        $form = Form::find($id);
        $form_columns = FormColumn::where('form_id', $id)->get();
        $response = [
            'form' => $form,
            'form_columns' => $form_columns
        ];
        return response($response, 201);
        // $form_column = 
    }
}
