<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeEvent;
use App\Models\Lieu;
use App\Models\Evenement;

class EvenementController extends Controller
{
    public function create()
    {
      
    }

    public function creer(Request $request)
    {
        $event_type = TypeEvent::all();
        $lieu = Lieu::all();
        $nom = $request->input('label');
        $date = $request->input('daty');
        $nbr_place = $request->input('nbr_pers');
        $tarif = $request->input('tarif_lieu');

        Evenement::create([
            'label' => $nom,
            'id_type_event' => $event_type,
            'id_lieu' => $lieu,
            'daty' => $date,
            'tarif_lieu' => $tarif
        ]);

        $liste_lieu = Lieu::with(['lieu'])->get();
        $liste_type_event = TypeEvent::orderby("id","asc")->get();


        return view("evenement", ['event_type' => $event_type, 'lieu' => $lieu, 'liste_lieu'=> $liste_lieu, 'liste_type_event' => $liste_type_event]);
    }
    
}
