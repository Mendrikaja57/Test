<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lieu;
use App\Models\Evenement;
use App\Models\TypeEvent;
use App\Models\Sonorisation;
use App\Models\Logistique;
use App\Models\Artiste;
use App\Models\Event_Artiste; 
use App\Models\Event_Sono;
use App\Models\Event_Logis;
use App\Models\Event_autre_depense;
use App\Models\AutreDepense;




class InsertController extends Controller
{
    public function insert_devis(Request $request){
        $id_lieu = $request->input('lieu');
        $label_event = $request->input('nom');
        $daty = $request->input('daty');
        $id_type_event = $request->input('type_event');
        $prix_vip = $request->input('prix_vip');
        $prix_reserve = $request->input('prix_reserve');
        $prix_normal = $request->input('prix_normal');
        $tarif_lieu = $request->input('tarif_lieu');

        Evenement::create([
            'label' => $label_event,
            'id_type_event' => $id_type_event,
            'id_lieu' => $id_lieu,
            'daty' => $daty,
            'prix_vip' => $prix_vip,
            'prix_reserve' => $prix_reserve,
            'prix_normal' => $prix_normal,
            'tarif_lieu' => $tarif_lieu,

        ]);

        $liste_lieu = Lieu::orderBy("id","asc")->get();
        $liste_type_event = TypeEvent::orderBy("id","asc")->get();

        return view("evenement", compact("liste_lieu", "liste_type_event"));
    }

    public function insert_artiste_devis(Request $request){
        $id_event = $request->input('id_event');
        $id_artiste = $request->input('id_artiste');
        $duree = $request->input('duree');
        //  id_evenement | id_artiste | duree
        Event_Artiste::create([
            'id_event' => $id_event,
            'id_artiste' => $id_artiste,
            'duree_artiste' => $duree
        ]);

        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_artiste = Artiste::orderBy("id","asc")->get();

        return view("DevisEventArtiste", compact("liste_event", "liste_artiste"));
    }

    public function upload(Request $request){
        if($request->hasFile('photo')){
            $photo=$request->file('photo');
            $filename=time().'.'.$photo->getClientOriginalName();
            // dd($filename," name ",$photo->getClientOriginalname());
            // $photo1->move('C:\xampp\htdocs\FOevaluation\public\assets\img',$filename);
           $photo->move(public_path('imgs'),$filename);
           DB::update('update artiste set photo=? where id=?',[$filename,$request->artiste]);  
           $s= public_path('imgs').'/'.$filename;
           $d='D:/Etudes/Evaluation2/Evenement/public/assets/img'.$filename;
            File::copy($s,$d);
        }
        return redirect()->route('photoartiste');
    }

    public function insert_sono_devis(Request $request){
        $id_event = $request->input('id_event');
        $id_sono = $request->input('id_sono');
        $duree = $request->input('duree');
        //  id_evenement | id_sono | duree
        Event_Sono::create([
            'id_event' => $id_event,
            'id_sono' => $id_sono,
            'duree_sono' => $duree
        ]);

        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_sono = Sonorisation::orderBy("id","asc")->get();

        return view("DevisEventSono", compact("liste_event", "liste_sono"));
    }

    public function insert_logis_devis(Request $request){
        $id_event = $request->input('id_event');
        $id_logis = $request->input('id_logis');
        $duree = $request->input('duree');
        //  id_evenement | id_sono | duree
        Event_Logis::create([
            'id_event' => $id_event,
            'id_logis' => $id_logis,
            'duree_logis' => $duree
        ]);

        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_logis = Logistique::orderBy("id","asc")->get();

        return view("DevisEventLogis", compact("liste_event", "liste_logis"));
    }

    public function insert_autre_devis(Request $request){
        $id_event = $request->input('id_event');
        $id_autre = $request->input('id_autre');
        $tarif = $request->input('tarif');
        //  id_evenement | id_artiste | duree
        Event_autre_depense::create([
            'id_event' => $id_event,
            'id_autre_depense' => $id_autre,
            'tarif' => $tarif
        ]);

        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_autre = AutreDepense::orderBy("id","asc")->get();

        return view("DevisEventAutre", compact("liste_event", "liste_autre"));
    }

    
    public function update_event($id){
        $event = Evenement::find($id);
        $liste_lieu = Lieu::orderBy("id","asc")->get();
        $liste_type_event = TypeEvent::orderBy("id","asc")->get();
        return view("ModifDevis", compact("liste_lieu", "liste_type_event", "event"));
    }

    public function update_event2(Request $request){
        $id = $request->input('id_event');
        
        $id_lieu = $request->input('id_lieu');
        $tarif_lieu = $request->input('tarif_lieu');

        $label = $request->input('label');
        $daty = $request->input('daty');
        $id_type_event = $request->input('id_type_event');

        $prix_vip = $request->input('prix_vip');
        $prix_reserve = $request->input('prix_reserve');
        $prix_normale = $request->input('prix_normale');

        //  id | label | id_type_event | id_lieu | tarif_lieu | daty | tarif_vip | tarif_reserve | tarif_normal
        $event = Evenement::find($id);
        $event->id = $id;
        $event->label = $label;
        $event->id_type_event = $id_type_event;
        $event->id_lieu = $id_lieu;
        $event->tarif_lieu = $tarif_lieu;
        $event->daty = $daty;
        $event->prix_vip = $prix_vip;
        $event->prix_reserve = $prix_reserve;
        $event->prix_normal = $prix_normale;
        $event->save();

        $liste_event = Evenement::orderBy("id","asc")->get();
        return view("liste_devis", compact("liste_event"));
    }

    public function update_artiste($id){
        $artiste = Event_Artiste::find($id);
        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_artiste = Artiste::orderBy("id","asc")->get();

        return view("ModifArtiste", compact("liste_event", "liste_artiste", "artiste"));
    }

    public function update_artiste2(Request $request){
        $id = $request->input('id');
        $id_artiste = $request->input('id_artiste');
        $duree_artiste = $request->input('duree');

        $artiste = Event_Artiste::find($id);
        $artiste->id_artiste = $id_artiste;
        $artiste->duree_artiste = $duree_artiste;
        $artiste->save();

        $liste_event = Evenement::orderBy("id","asc")->get();
        return view("liste_devis", compact("liste_event"));
    }

    public function update_sono($id){
        $sono = Event_Sono::find($id);
        $liste_event = Evenement::orderBy("id","asc")->get();
       

        return view("ModifSono", compact("liste_event", "sono"));
    }

    public function update_sono2(Request $request){
        $id = $request->input('id');
        $id_sono = $request->input('id_sono');
        $label = $request->input('label');
        $duree_sono = $request->input('duree_sono');

        $sono = Event_Sono::find($id);
        $sono->id_sono = $id_sono;
        $sono->label = $label;
        $sono->duree_sono = $duree_sono;
        $sono->save();

        $liste_event = Evenement::orderBy("id","asc")->get();
        return view("liste_devis", compact("liste_event"));
    }

    public function update_logis($id){
        $logi = Event_logis::find($id);
        $liste_event = Evenement::orderBy("id","asc")->get();

        return view("ModifLogis", compact("liste_event", "logi"));
    }

    public function update_logis2(Request $request){
        $id = $request->input('id');
        $id_logis = $request->input('id_logis');
        $label = $request->input('label');
        $duree_logis = $request->input('duree_logis');

        $logi = Event_Logis::find($id);
        $logi->id_logis = $id_logis;
        $logi->Label = $label;
        $logi->duree_logis = $duree_logis;
        $logi->save();

        $liste_event = Evenement::orderBy("id","asc")->get();
        return view("liste_devis", compact("liste_event"));
    }


    public function update_autre($id){
        $autre = Event_autre_depense::find($id);
        $liste_autre = AutreDepense::orderBy("id","asc")->get();

        return view("ModifAutre", compact("liste_autre", "autre"));
    }

    public function update_autre2(Request $request){
        $id = $request->input('id');
        $id_autre_depense = $request->input('id_autre_depense');
        $tarif = $request->input('tarif');

        $autre = Event_autre_depense::find($id);
        $autre->id_autre_depense = $id_autre_depense;
        $autre->tarif = $tarif;
        $autre->save();

        $liste_event = Evenement::orderBy("id","asc")->get();
        return view("liste_devis", compact("liste_event"));
    }

    public function update_so($id){
        $sono = Event_Sono::find($id);
        $liste_event = Evenement::orderBy("id","asc")->get();
       

        return view("ModifSono", compact("liste_event", "sono"));
    }

}
