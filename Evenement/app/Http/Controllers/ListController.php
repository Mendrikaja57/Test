<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lieu;
use App\Models\TypeEvent;
use App\Models\Evenement;
use App\Models\Sonorisation;
use App\Models\Logistique;
use App\Models\Artiste;
use App\Models\AutreDepense;
use App\Models\Event_Artiste; 
use App\Models\Event_Sono;
use App\Models\Event_Logis;
use App\Models\Event_autre_depense;


class ListController extends Controller
{
    public function ajoutDevis(){
        $liste_lieu = Lieu::orderBy("id","asc")->get();
        $liste_type_event = TypeEvent::orderBy("id","asc")->get();

        return view("evenement", compact("liste_lieu", "liste_type_event"));
    }

    public function ajoutArtisteDevis(){
        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_artiste = Artiste::orderBy("id","asc")->get();

        return view("DevisEventArtiste", compact("liste_event", "liste_artiste"));
    }

    public function ajoutSonoDevis(){
        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_sono = Sonorisation::orderBy("id","asc")->get();

        return view("DevisEventSono", compact("liste_event", "liste_sono"));
    }

    public function ajoutLogisDevis(){
        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_logis = Logistique::orderBy("id","asc")->get();

        return view("DevisEventLogis", compact("liste_event", "liste_logis"));
    }

    public function ajoutAutreDevis(){
        $liste_event = Evenement::orderBy("id","asc")->get();
        $liste_autre = AutreDepense::orderBy("id","asc")->get();

        return view("DevisEventAutre", compact("liste_event", "liste_autre"));
    }

    public function listeDevis(){
        $liste_event = Evenement::orderBy("id","asc")->get();

        return view("liste_devis", compact("liste_event"));
    }

    public function ModifAutre(){
        $liste_autre = AutreDepense::orderBy("id","asc")->get();

        return view("ModifAutre", compact("liste_autre"));
    }
    
    public function depenseByIdEvent($id){
        // liste EvenementAutreDepense
        $lead = Event_autre_depense::where('id_event',$id)->get();
        // liste EvenementArtiste
        $lea = Event_Artiste::with(['event', 'artiste'])->where('id_event',$id)->get();
        // liste EvenementLogi
        $lel = Event_Logis::with(['event', 'logis'])->where('id_event',$id)->get();
        // liste EvenementSono
        $les = Event_Sono::with(['event', 'sono'])->where('id_event',$id)->get();
        // evenement
        $event = Evenement::where('id',$id)->get();

        // somme evenementAutreDepense
        $somme_ead = 0;
        foreach($lead as $ead){
            $somme_ead += $ead->tarif;
        }
        
        // somme evenementArtiste
        $somme_ea = 0;
        foreach($lea as $ea){
            $somme_ea += $ea->artiste->tarif_par_heure * $ea->duree;
        }
        // somme EvenementLogi
        $somme_el = 0;
        foreach($lel as $el){
            $somme_el += $el->logis->tarif_jour * $el->duree_logis;
        }
        // somme EvenementSono
        $somme_es = 0;
        foreach($les as $es){
            $somme_es += $es->sono->tarif_heure * $es->duree_sono;
        }

        // tarrif lieu
        $tarif_lieu = $event[0]->tarif_lieu;

        // dépense
        $somme_totale = $somme_ead + $somme_ea + $somme_el + $somme_es + $tarif_lieu;

        // recette
        $vip = $event[0]->prix_vip * $event[0]->lieuevent->nbr_vip;
        $reserve = $event[0]->prix_reserve * $event[0]->lieuevent->nbr_reserve;
        $normal = $event[0]->prix_normal * $event[0]->lieuevent->nbr_normal;
        $recette = $vip + $reserve + $normal;

        // benefice
        $benefice = $recette - $somme_totale;

        return view("detailDevis", [
            'id' => $id,
            'somme_ead' => $somme_ead,
            'lead' => $lead,
            'somme_ea' => $somme_ea,
            'lea' => $lea,
            'lel' => $lel,
            'les' => $les,
            'event' => $event[0],
            'tarif_lieu' => $tarif_lieu,
            'somme_el' => $somme_el,
            'somme_es' => $somme_es,
            'somme_totale' => $somme_totale,
            'recette' => $recette,
            'benefice' => $benefice
        ]);

       
    }

    function generatePdf($iddevis)
    {

         // liste EvenementAutreDepense
         $lead = Event_autre_depense::where('id_event',$id)->get();
         // liste EvenementArtiste
         $lea = Event_Artiste::with(['event', 'artiste'])->where('id_event',$id)->get();
         // liste EvenementLogi
         $lel = Event_Logis::with(['event', 'logis'])->where('id_event',$id)->get();
         // liste EvenementSono
         $les = Event_Sono::with(['event', 'sono'])->where('id_event',$id)->get();
         // evenement
         $event = Evenement::where('id',$id)->get();

         $somme_ead = 0;
         foreach($lead as $ead){
             $somme_ead += $ead->tarif;
         }
         
         // somme evenementArtiste
         $somme_ea = 0;
         foreach($lea as $ea){
             $somme_ea += $ea->artiste->tarif_par_heure * $ea->duree;
         }
         // somme EvenementLogi
         $somme_el = 0;
         foreach($lel as $el){
             $somme_el += $el->logis->tarif_jour * $el->duree_logis;
         }
         // somme EvenementSono
         $somme_es = 0;
         foreach($les as $es){
             $somme_es += $es->sono->tarif_heure * $es->duree_sono;
         }
 
         // tarrif lieu
         $tarif_lieu = $event[0]->tarif_lieu;
 
         // dépense
         $somme_totale = $somme_ead + $somme_ea + $somme_el + $somme_es + $tarif_lieu;
 
         // recette
         $vip = $event[0]->prix_vip * $event[0]->lieuevent->nbr_vip;
         $reserve = $event[0]->prix_reserve * $event[0]->lieuevent->nbr_reserve;
         $normal = $event[0]->prix_normal * $event[0]->lieuevent->nbr_normal;
         $recette = $vip + $reserve + $normal;
 
         // benefice
         $benefice = $recette - $somme_totale;

         return view("detailDevis", [
            'id' => $id,
            'somme_ead' => $somme_ead,
            'lead' => $lead,
            'somme_ea' => $somme_ea,
            'lea' => $lea,
            'lel' => $lel,
            'les' => $les,
            'event' => $event[0],
            'tarif_lieu' => $tarif_lieu,
            'somme_el' => $somme_el,
            'somme_es' => $somme_es,
            'somme_totale' => $somme_totale,
            'recette' => $recette,
            'benefice' => $benefice
        ]);
        $pdf = PDF::loadView('pdf.affiche',['somme_totale'=>$somme_totale,'event'=>$event[0],'lea' => $lea,]);
        return $pdf->download('affiche.pdf');
    }

}
