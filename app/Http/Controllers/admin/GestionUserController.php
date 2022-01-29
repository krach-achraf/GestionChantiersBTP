<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class GestionUserController extends Controller
{
    public function index(){
       $listUsers = User::where('admin','=',0)->get();
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.users.users', ['users' => $listUsers]);
        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request){
        if (Auth::check() && Auth::user()->admin) {
            $request->validate([
                'nom' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ \']+$/u|min:3',
                'prenom' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ \']+$/u|min:3',
                'email' => 'required|unique:users|email',
                'role' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ \']+$/u|min:3',
                'password' => 'required|min:6',
            ]);

            $user= new User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('successStoreUser', 'Le responsable a été bien enregistré');
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function edit($id){
        $user = User::find($id);
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.users.editUser', ['user' => $user]);
        }else{
            return redirect()->back();
        }

    }

    public function update(Request $request, $id){
        if (Auth::check() && Auth::user()->admin) {
            $request->validate([
                'nom' => 'required|regex:/^[a-zA-Z ]+$/u|min:3',
                'prenom' => 'required|regex:/^[a-zA-Z ]+$/u|string|min:3',
                'email' => 'required|email',
                'role' => 'required|regex:/^[a-zA-Z ]+$/u|string|min:3',
            ]);

            $user = User::find($id);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->save();

            session()->flash('successEditUser', 'Le responsable a été bien modifié');
            return redirect('utilisateurs');
        }else{
            return redirect()->back();
        }

    }

    public function destroy($id){
        $user = User::find($id);
        if (Auth::check() && Auth::user()->admin) {
            $user->delete();

            return response()->json(['status'=>'Le responsable a été bien supprimé']);
        }else{
            return redirect()->back();
        }

    }


    public function taches($id){
        $taches  = DB::table('taches')
            ->select('taches.*','projets.title as libelleProjet')
            ->join('projets','taches.projet_id','=','projets.id')
            ->where('taches.user_id','=',$id)
            ->get();
        return Response::json($taches);
    }

    public function profil(){
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.profil.profil');
        }else{
            return redirect()->back();
        }
    }

    public function editProfil($id){
        $admin = User::find($id);
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.profil.editProfil',['admin' => $admin]);
        }else{
            return redirect()->back();
        }
    }
    public function updateProfil(Request $request,$id){

        if (Auth::check() && Auth::user()->admin) {
            $request->validate([
                'nom' => 'required|regex:/^[a-zA-Z ]+$/u|min:3',
                'prenom' => 'required|regex:/^[a-zA-Z ]+$/u|min:3',
                'email' => 'required|email',
            ]);

            $admin = User::find($id);
            $admin->nom = $request->nom;
            $admin->prenom = $request->prenom;
            $admin->email = $request->email;
            $admin->save();

            session()->flash('successEditAdmin', 'La modification a été bien enregistré');
            return redirect('/administrateur/profil');
        }else{
            return redirect()->back();
        }
    }

    public function changeMotDePasse(){
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.profil.motDePasse');
        }else{
            return redirect()->back();
        }
    }

    public function storeMotDePasse(Request $request){
        if (Auth::check() && Auth::user()->admin) {
            if (!(Hash::check($request->get('ancienMotDePasse'),Auth::user()->password))){
                return back()->with('errorAncienmdp','L\'ancien mot de passe est incorrect');
            }
            if (strcmp($request->get('ancienMotDePasse'),$request->get('nouveauMotDePasse')) == 0){
                return back()->with('errorAncienNouveaumdp','Le nouveau mot de passe est indentique au ancien mot de passe');
            }

            $request->validate([
                'ancienMotDePasse' => 'required',
                'nouveauMotDePasse' => 'required|string|min:0|same:confirmationMotDePasse'
            ]);

            $user = Auth::user();
            $user->password = bcrypt($request->get('nouveauMotDePasse'));
            $user->save();

            session()->flash('successStoreMdp', 'Le mot de passe a été bien modifié');
            return view('admin.profil.profil');
        }else{
            return redirect()->back();
        }
    }}
