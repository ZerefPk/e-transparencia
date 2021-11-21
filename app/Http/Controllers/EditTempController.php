<?php

namespace App\Http\Controllers;

use App\Models\Bidding\Bidding;
use Illuminate\Http\Request;

class EditTempController extends Controller
{
    //
    public function update(){
        $data = Bidding::all();

        foreach($data as $temp){
            $temp->object = strip_tags(html_entity_decode($temp->object , ENT_COMPAT, 'UTF-8'));
            $temp->update();
        }
        dd(true);
    }
}
