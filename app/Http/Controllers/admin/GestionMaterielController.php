<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use App\Models\Materiel;
use App\Models\MaterielFournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class GestionMaterielController extends Controller
{
    public function index(){

        $listMateriels = DB::table('fournisseur_materiel')
            ->select('fournisseur_materiel.id','materiels.id as materiel_id','materiels.libelle','materiels.photo','fournisseurs.nom','fournisseurs.prenom','fournisseur_materiel.dateAccuse','fournisseur_materiel.id as fournisseur_materiel_id')
            ->join('materiels','fournisseur_materiel.materiel_id','=','materiels.id')
            ->join('fournisseurs','fournisseur_materiel.fournisseur_id','=','fournisseurs.id')
            ->whereNull('materiels.deleted_at')
            ->whereNull('fournisseur_materiel.deleted_at')
            ->get();
            if (Auth::check() && Auth::user()->admin) {
                return view('admin.materiels.materiels', ['materiels' => $listMateriels]);
            }else {
                return redirect()->back();
            }

    }

    public function create(){
        $listFournisseurs = Fournisseur::all();
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.materiels.ajoutMateriels', ['fournisseurs' => $listFournisseurs]);
        }else {
            return redirect()->back();
        }

    }

    public function store(Request $request){
        if (Auth::check() && Auth::user()->admin) {
            $input = $request->all();

                foreach($request->libelle as $key => $value) {
                    $libelle[$key] = $input['libelle'][$key];
                    $count[$key] = Materiel::where('libelle', '=', $libelle[$key])
                        ->whereNull('deleted_at')
                        ->count();

                    if ($count[$key] == 0){
                        $request->validate([
                            'libelle.*' => 'required|min:5',
                            'dateAccuse.*' => 'required|date',
                            'photo.*' => 'required|image',
                            'fournisseur.*' => 'required',
                        ]);
                        if ($request->hasFile('photo')) {
                            $dossier = 'public/images/materiels';
                            $image = $input['photo'][$key];
                            $image_nom = $image->getClientOriginalName();
                            $path = $input['photo'][$key]->storeAs($dossier, $image_nom);

                            $materiel = new Materiel();
                            $materiel->libelle = $input['libelle'][$key];
                            $materiel->photo = $image_nom;
                            $materiel->save();

                            $this->saveFournisseurs($input['fournisseur'][$key], $input['libelle'][$key], $input['dateAccuse'][$key]);
                        }
                    }else{
                        $request->validate([
                            'libelle.*' => 'required|min:5',
                            'dateAccuse.*' => 'required|date',
                            'photo.*' => 'image',
                            'fournisseur.*' => 'required',
                        ]);
                        $this->saveFournisseurs($input['fournisseur'][$key],$input['libelle'][$key],$input['dateAccuse'][$key]);
                    }
                }
                session()->flash('successStoreMateriel', 'les materiels ont été bien enregitsré');

            return redirect('materiels');
        }else {
            return redirect()->back();
        }

    }

    public function saveFournisseurs($idFournisseur,$libelle,$dateAccuse){
        $idMateriel = Materiel::where('libelle', '=', $libelle)->firstOrFail();
        $materielFournisseur = new MaterielFournisseur();
        $materielFournisseur->fournisseur_id = $idFournisseur;
        $materielFournisseur->materiel_id = $idMateriel->id;
        $materielFournisseur->dateAccuse = $dateAccuse;
        $materielFournisseur->save();
    }

    public function edit($id){
        $materiel = Materiel::find($id);
        $materielFournisseurs = DB::table('fournisseur_materiel')
            ->select('fournisseurs.id as fournisseur_id','fournisseurs.nom','fournisseurs.prenom','fournisseur_materiel.id','fournisseur_materiel.dateAccuse')
            ->where('materiel_id','=',$id)
            ->join('fournisseurs','fournisseurs.id','fournisseur_materiel.fournisseur_id')
            ->get();
        $fournisseurs = Fournisseur::all();
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.materiels.editMateriel' , ['materiel' => $materiel , 'fournisseurs' => $fournisseurs , 'materielFournisseurs' => $materielFournisseurs]);
        }else {
            return redirect()->back();
        }
    }

    public function update(Request $request,$id){
        if (Auth::check() && Auth::user()->admin) {
            $request->validate([
                'libelle' => 'required|min:3',
                'photo' => 'image',
                'dateAccuse.*' => 'required|date',
                'fournisseur.*' => 'required',
            ]);
            $input = $request->all();

            $materiel = Materiel::find($id);
            $materiel->libelle = $request->libelle;

            if ($request->hasFile('photo')){
                $dossier = 'public/images/materiels';
                $image = $request->file('photo');
                $image_nom = $image->getClientOriginalName();
                $path = $request->file('photo')->storeAs($dossier,$image_nom);

                $materiel->photo = $image_nom;
            }

            $materiel->save();


            $this->updateFournisseur($id,$input['fournisseur'],$input['dateAccuse']);


            session()->flash('successEditMateriel', 'le materiel a été bien modifié');
            return redirect('materiels');
        }else {
            return redirect()->back();
        }
    }

    public function updateFournisseur($id,$fournisseurs,$dateAccuses){
        foreach($fournisseurs as $key => $fournisseur){
            $data = array(
                'fournisseur_id' => $fournisseur,
                'dateAccuse' => $dateAccuses[$key]
            );
        }
        MaterielFournisseur::where('materiel_id','=',$id)->update($data);
    }

    public function search(){
        $reponse = $_GET['queryMateriel'];
        $materiels = Materiel::where('libelle','Like','%'.$reponse.'%')->get();
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.materiels.rechercheMateriel', ['materiels' => $materiels]);
        }else {
            return redirect()->back();
        }

    }

    public function destroy($id,$idTable2){
        $materiel = Materiel::find($id);
        $count = MaterielFournisseur::where('materiel_id', '=', $id)
            ->whereNull('deleted_at')
            ->count();
        if (Auth::check() && Auth::user()->admin) {
            if ($count == 1){
                $materiel->delete();
                MaterielFournisseur::where('id','=',$idTable2)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                return response()->json(['status'=>'le materiel a été bien supprimé']);
            }elseif ($count >= 1){
                MaterielFournisseur::where('id','=',$idTable2)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                return response()->json(['status'=>'le materiel a été bien supprimé']);
            }
        }else {
            return redirect()->back();
        }
    }

    public function getFournisseurs()
    {
        $fournisseurs = DB::table('fournisseurs')->get();

        return Response::json($fournisseurs);
    }

}
