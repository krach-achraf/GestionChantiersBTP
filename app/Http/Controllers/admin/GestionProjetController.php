<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MaterielTache;
use App\Models\Projet;
use App\Models\Tache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class GestionProjetController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Projet::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
            return Response::json($data);
        }
        return view('admin.projets.projets');
    }


    public function create(Request $request)
    {
        $end = Carbon::parse($request->start);
        $end->addHours(1);

        if(request()->ajax()) {
            $rules = array(
                'title'      => 'required|unique:projets|min:5',
                'description'      => 'required|unique:projets|min:10',
                'localisation'      => 'required|min:5',
                'start'      => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){
                return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
            }

            $insertArr = [
                'title' => $request->title,
                'start' => $request->start,
                'end' => $end,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $event = Projet::insert($insertArr);
            return Response::json($event);
        }

    }

    public function liste(){
        $projets = Projet::all();
        return view('admin.projets.listeProjet',['projets' => $projets]);
    }

    public function edit($id){
        $projet = Projet::find($id);
        if (Auth::check() && Auth::user()->admin) {
            if ($projet->etat == 'terminé'){
                return redirect()
                    ->back()
                    ->with('alertProjetTerminéEdit', 'Le projet est terminé');
            }else{
                return view('admin.projets.editProjet',['projet' => $projet]);
            }
        }else {
            return redirect()->back();
        }
    }

    public function update(Request $request,$id){
        if (Auth::check() && Auth::user()->admin) {
            $projet = Projet::find($id);
            $end = Carbon::parse($projet->start);
            $end->addHours(1);

            $rules = array(
                'libelle' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|min:5',
                'description' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|min:10',
                'localisation' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|min:5',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $updateProjet = [
                'title' => $request->libelle,
                'start' => $projet->start,
                'end' => $end,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            Projet::where('id','=',$id)->update($updateProjet);

            session()->flash('successEditProjet', 'le projet a été bien modifié');
            return redirect('projets/liste');
        }else {
            return redirect()->back();
        }

    }

    public function dateChange(Request $request)
    {
        $projet = Projet::find($request->id);
        $end = Carbon::parse($request->start);
        $end->addHours(1);

        if ($projet->etat == 'en cours' || $projet->etat == 'terminé'){
            return Response::json('projet terminé ou en cours', 422);
        }

        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $end,'updated_at' => date('Y-m-d H:i:s')];

        $event  = Projet::where($where)->update($updateArr);

        return Response::json($event);
    }

    public function destroy(Request $request)
    {
        $projet = Projet::find($request->id);

        if ($projet->etat == 'terminé'){
            return Response::json('projet terminé', 422);
        }

        $projet->delete();
        return Response::json($projet);

    }

    public function enCours($id){
        $projet = Projet::find($id);
        $end = Carbon::parse($projet->start);
        $end->addHours(1);

        $updateProjet = [
            'etat' => 'en cours',
            'updated_at' => date('Y-m-d H:i:s'),
            'start' => $projet->start,
            'end' => $end,
        ];

        Projet::where('id','=',$id)->update($updateProjet);

        session()->flash('ProjetEncous', 'Modification faite avec succée');
        return redirect()->back();
    }

    public function terminé($id){
        $projet = Projet::find($id);
        $end = Carbon::parse($projet->start);
        $end->addHours(1);

        $updateProjet = [
            'etat' => 'terminé',
            'updated_at' => date('Y-m-d H:i:s'),
            'start' => $projet->start,
            'end' => $end,
        ];

        Projet::where('id','=',$id)->update($updateProjet);

        session()->flash('ProjetTerminé', 'Modification faite avec succée');
        return redirect()->back();
    }

}
