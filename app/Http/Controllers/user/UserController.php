<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profil(){
        if (Auth::check() && !Auth::user()->admin) {
            return view('utilisateur.user.profil');
        }else{
            return redirect()->back();
        }

    }

    public function changeMotDePasse(){
        if (Auth::check() && !Auth::user()->admin) {
            return view('utilisateur.user.changeMotDePasse');
        }else{
            return redirect()->back();
        }
    }

    public function storeMotDePasse(Request $request){
        if (Auth::check() && !Auth::user()->admin) {
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
            return view('utilisateur.user.profil');
        }else{
            return redirect()->back();
        }
    }
}
