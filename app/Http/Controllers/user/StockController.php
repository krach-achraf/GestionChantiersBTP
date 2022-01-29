<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function showStock()
    {
        $listStocks = DB::table('stocks')
            ->select('stocks.id','stocks.quantite','stocks.unite','articles.libelle')
            ->join('articles','articles.id','=','stocks.article_id')
            ->get();
        return view('utilisateur.stock.stock', ['stocks' => $listStocks]);
    }


    public function addStock()
    {
        $article = Article::all();
        return view('utilisateur.stock.ajoutStock')->with('article', $article);
    }

    public function store(Request $request)
    {
        $request->validate([
            /*'libelle' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|unique:projets|min:3',*/
            'quantite' => 'required|regex:/^[+-]?([0-9]*[.])?[0-9]+/|not_in:0',
            /*'unite' => 'required|regex:/^[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ1-90 \']+$/u|min:3',*/
        ]);
        $article= $request->get('article_id');
        $quantite=$request->get('quantite');
        $unite = $request->get('unite');
        $listStocks = DB::table('stocks')
            ->select('stocks.id','stocks.article_id','stocks.quantite','stocks.unite','articles.libelle')
            ->join('articles','articles.id','=','stocks.article_id')
            ->get();
        $var=0;
        foreach ($listStocks as $listStock){

            if ($listStock->article_id == $article && $listStock->unite == $unite){
                $listmodifer = $listStock;
                $var+=1;
            }
        }
        if($var==0){
            $listStock = new Stock([
                'article_id' => $request->get('article_id'),
                'quantite' => $request->get('quantite'),
                'unite' => $request->get('unite'),
            ]);
            $listStock->save();
            session()->flash('succesStoreAdd', 'Article a été bien ajouter au stock');

        }else{
            $listmodifer->quantite += $quantite;
            $Stock = new Stock([
                'id'=>$listmodifer->id,
                'article_id' => $listmodifer->article_id,
                'quantite' => $listmodifer->quantite,
                'unite' => $listmodifer->unite,
            ]);
            $id=$listmodifer->id;
            $srock = Stock::find($id);

            $srock->delete();
            $Stock->save();

            session()->flash('succesStoreAdd', 'Article a été bien ajouter au stock');
        }
        return redirect('stocks');


    }

    public function search(Request $request)
    {
        $stocks = DB::table('stocks')
            ->select('stocks.id','stocks.quantite','stocks.unite','articles.libelle')
            ->join('articles','articles.id','=','stocks.article_id')
            ->where('libelle', 'like', '%'.$request->libelleRecherche.'%')
            ->get();
        return view('utilisateur.stock.stockRecherche', ['stocks' => $stocks]);
    }


}
