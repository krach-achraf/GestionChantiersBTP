<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Materiel;
use App\Models\MaterielTache;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterielAffectController extends Controller
{
    public function showMateriel()
    {
        $materielprojet = DB::table('materiel_projet')
            ->select('materiel_projet.id','materiel_projet.materiel_id','materiel_projet.projet_id','materiels.libelle','materiel_projet.dateDebut','materiel_projet.dateFin')
            ->join('materiels','materiels.id','=','materiel_projet.materiel_id')
            ->join('projets','projets.id','=','materiel_projet.projet_id')
            ->get();
        $projetsAll = DB::table('projets')
            ->get();
        return view('utilisateur.materielAffect',['materielprojet' => $materielprojet],['projetsAll' => $projetsAll]);
    }
/*    Pour affecte un materiel a un projet*/
    public function create($id){
        $materiel = Materiel::all();
        $projet = DB::table('projets')
            ->where('id','like','%'.$id.'%')
            ->get();
        return view('utilisateur.ajoutmaterielAffect',['projet' => $projet],['materiel' => $materiel]);
    }
    public function store(Request $request)
    {
        $request->validate([
            /*'libelle' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|unique:projets|min:3',*/
            'dateDebut' => 'required',
            'dateFin' => 'required',
            /*'unite' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|min:3',*/
        ]);
        $id =$request->get('projet_id');
        $id1 = $request->get('materiel_id');
        $date1 = strtotime($request->get('dateDebut'));
        $date2 = strtotime($request->get('dateFin'));
        $result = $date2-$date1;
        $notreBase = DB::table('materiel_projet')
            ->where('projet_id', 'like', '%'.$id.'%')
            ->get();
        $var=0;
        foreach ($notreBase as $nt){
            if ($nt->materiel_id == $id1){
                $var +=1;
            }
        }
        if($var == 0 && $result > 0){
            $materiel_projet = new MaterielTache([
                'materiel_id' => $request->get('materiel_id'),
                'projet_id' => $request->get('projet_id'),
                'dateDebut' => $request->get('dateDebut'),
                'dateFin' => $request->get('dateFin'),
            ]);

            $materiel_projet->save();
            session()->flash('succesAffect', 'Materiel a été bien affecter au projet');
            return redirect('affectation_materiel');
        }else if ($var != 0 && $result > 0){
            session()->flash('DejaAffecter', 'Ce materiel que vous avez choisi est deja affecter à ce projet !!');
            return redirect()->back();
        }else if ($var == 0 && $result <= 0){
            session()->flash('dateFinInvalid', 'Choisir une date supérieur à date Debut');
            return redirect()->back();
        }else if ($var != 0 && $result <= 0) {
            session()->flash('DejaAffecter', 'Ce materiel que vous avez choisi est deja affecter à ce projet !!');
            return redirect()->back();
        }
    }

    /******************************** validation ********************************/

    public function validation(){
        $materielTache = DB::table('materiel_tache')
            ->select('materiel_tache.id','materiels.libelle as libelleMateriel','taches.libelle','materiel_tache.dateDebut','materiel_tache.dateFin','materiel_tache.validité','users.nom','users.prenom')
            ->join('materiels','materiels.id','=','materiel_tache.materiel_id')
            ->join('taches','taches.id','=','materiel_tache.tache_id')
            ->join('users','users.id','=','taches.user_id')
            ->get();
        if (Auth::check() && Auth::user()->admin) {
        return view('admin.validation.matériels',['materiels' => $materielTache]);
        }else{
            return redirect()->back();
        }
    }

    public function pasValidé($id){
        $materiel = MaterielTache::find($id);
        if (Auth::check() && Auth::user()->admin) {
            $materiel->validité = 'Pas validé';
            $materiel->save();
            $materiel->delete();
            session()->flash('pasValidéMateriel', 'Le transfère du matériel est marqué comme non validé');
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function validé($id){
        $materiel = MaterielTache::find($id);
        if (Auth::check() && Auth::user()->admin) {
            $materiel->validité = 'Validé';
            $materiel->save();
            session()->flash('ValidéMateriel', 'Le transfère du matériel est marqué comme validé');
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}
