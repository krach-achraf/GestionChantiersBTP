<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleTache;
use App\Models\Fournisseur;
use App\Models\FournisseurArticle;
use App\Models\Stock;
use App\Models\Tache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ArticleTacheController extends Controller
{


    public function index(){
        if (Auth::check() && !Auth::user()->admin) {
            $userId = Auth::user()->id;
            $listCommandes = DB::table('article_tache')
                ->select('article_tache.id','taches.libelle as libelleTache','articles.libelle as libelleArticle','fournisseurs.nom','fournisseurs.prenom','article_tache.quantité','article_tache.unité','article_tache.priorité','article_tache.created_at','article_tache.dateReception','article_tache.étatCommande','article_tache.validité')
                ->join('taches','taches.id','=','article_tache.tache_id')
                ->join('fournisseurs','fournisseurs.id','=','article_tache.fournisseur_id')
                ->join('articles','articles.id','=','article_tache.article_id')
                ->where('taches.user_Id','=',$userId)
                ->whereNull('article_tache.deleted_at')
                ->orderBy('article_tache.created_at', 'desc')
                ->get();
            return view('utilisateur.commandes.commandes',['commandes'=>$listCommandes]);
        }else{
            return redirect()->back();
        }
    }

    public function create(){
        if (Auth::check() && !Auth::user()->admin) {
            $userId = Auth::user()->id;
            $listProjets = DB::table('projets')
                ->distinct()
                ->select('projets.id','projets.title')
                ->join('taches','projets.id','=','taches.projet_id')
                ->where('taches.user_id','=',$userId)
                ->orderBy('projets.title') /*a ajouter aux autres interfaces */
                ->get();
            $listArticles = Article::all();
            $listFournisseurs = Fournisseur::all();
            return view('utilisateur.commandes.ajoutCommande',['projets' => $listProjets , 'articles' => $listArticles, 'fournisseurs' => $listFournisseurs]);
        }else{
            return redirect()->back();
        }

    }

    public function store(Request $request){
        if (Auth::check() && !Auth::user()->admin) {
            $request->validate([
                'tache' => 'required',
                'article' => 'required',
                'fournisseur' => 'required',
                'unité' => 'required',
                'priorité' => 'required',
                'quantité' => 'required|regex:/^[0-9]+[.0-9]*$/|not_in:0',
            ]);

            $tache_Id = $request->get('tache');
            $article_Id = $request->get('article');
            $fournisseur_Id = $request->get('fournisseur');
            $quantite = $request->get('quantité');
            $unite = $request->get('unité');
            $priorite = $request->get('priorité');
            $token = $request->get('_token');

            $stocks = DB::table('stocks')
                ->select('id','quantité')
                ->where('article_id','=',$article_Id)
                ->where('unité','=',$unite)
                ->get();

            foreach ($stocks as $stock){
                if ($quantite <= $stock->quantité){
                    return redirect()
                        ->back()
                        ->with('alertCommande', 'Article existe dans le stock')
                        ->with('id',$article_Id)
                        ->with('quantite',$quantite)
                        ->with('token',$token);
                }
            }
            $commande = new ArticleTache();
            $commande->article_id = $article_Id;
            $commande->tache_id = $tache_Id;
            $commande->fournisseur_id = $fournisseur_Id;
            $commande->quantité = $quantite;
            $commande->priorité = $priorite;
            $commande->unité = $unite;
            $commande->save();

            $fA = new FournisseurArticle();
            $fA->article_id = $article_Id;
            $fA->fournisseur_id = $fournisseur_Id;
            $fA->save();

            session()->flash('successStoreCommande', 'La commande a été bien enregistré');
            return redirect('commandes');
        }else{
            return redirect()->back();
        }
    }

    public function edit($id){
        $commande = ArticleTache::find($id);

        $commande->étatCommande = 'Reçu';
        $commande->dateReception = date('Y-m-d H:i:s');

        $commande->save();

        session()->flash('successEditCommande', 'La commande est marquée comme livré');
        return redirect('commandes');
    }


    public function destroy($id,$token){
        $commande = ArticleTache::find($id);


        if (Auth::check() && !Auth::user()->admin) {
            if ($commande->étatCommande == 'Livré'){
                return redirect()
                    ->back()
                    ->with('alertCommandeLivré', 'La commande est livré!');
            }else{
                return redirect()
                    ->back()
                    ->with('confirmDeleteCommande', 'Vous étes sur?')
                    ->with('idCommande',$id)
                    ->with('tokenCommande',$token);
            }
        }else{
            return redirect()->back();
        }
    }

    public function delete($id){
        $commande = ArticleTache::find($id);
        if (Auth::check() && !Auth::user()->admin) {
            $commande->delete();

            return response()->json(['status'=>'La commande a été bien supprimée']);
        }else{
            return redirect()->back();
        }
    }

    public function taches($id){
        $userId = Auth::user()->id;
        $taches = Tache::where('projet_id','=',$id)
            ->where('user_id','=',$userId)
            ->get();

        return Response::json($taches);
    }

    public function fournisseurs($id){
        $listProjets = DB::table('fournisseurs')
            ->select('fournisseurs.id','fournisseurs.nom','fournisseurs.prenom')
            ->join('fournisseur_article','fournisseurs.id','=','fournisseur_article.fournisseur_id')
            ->where('fournisseur_article.article_id','=',$id)
            ->get();
        return Response::json($listProjets);
    }

    public function stock($id,$quantite){
        $stock = Stock::where('article_id', $id)->first();

        $stock->quantité = $stock->quantité - $quantite;
        $stock->save();

        return response()->json(['status'=>'Modification effectué']);
    }

    public function validation()
    {
        $listCommandes = DB::table('article_tache')
            ->select('article_tache.id','taches.libelle as libelleTache','articles.libelle as libelleArticle','fournisseurs.nom','fournisseurs.prenom','article_tache.quantité','article_tache.unité','article_tache.priorité','article_tache.created_at','article_tache.dateReception','article_tache.étatCommande','article_tache.validité','users.nom as Usernom','users.prenom as Userprenom')
            ->join('taches','taches.id','=','article_tache.tache_id')
            ->join('users','taches.user_id','=','users.id')
            ->join('fournisseurs','fournisseurs.id','=','article_tache.fournisseur_id')
            ->join('articles','articles.id','=','article_tache.article_id')
            ->whereNull('article_tache.deleted_at')
            ->orderBy('article_tache.created_at', 'desc')
            ->get();
        if (Auth::check() && Auth::user()->admin) {
            return view('admin.validation.articles',['commandes' => $listCommandes]);
        }else{
            return redirect()->back();
        }
    }

    public function pasValidé($id){
        $commande = ArticleTache::find($id);
        if (Auth::check() && Auth::user()->admin) {
            $commande->validité = 'Pas validé';
            $commande->save();
            $commande->delete();
            session()->flash('pasValidéCommande', 'La commande est marqué comme non validé');
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function validé($id){
        $commande = ArticleTache::find($id);
        if (Auth::check() && Auth::user()->admin) {
            $commande->validité = 'Validé';
            $commande->save();
            session()->flash('ValidéCommande', 'La commande est marqué comme validé');
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}

