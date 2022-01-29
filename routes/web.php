<?php

use App\Http\Controllers\admin\GestionEditProjetController;
use App\Http\Controllers\admin\GestionMaterielController;
use App\Http\Controllers\admin\GestionProjetController;
use App\Http\Controllers\admin\GestionUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\ArticleTacheController;
use App\Http\Controllers\user\MaterielAffectController;
use App\Http\Controllers\user\StockController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/******************************************** ADMIN ********************************************/

/*********** MATERIEL ***********/
Route::get('/materiels', [GestionMaterielController::class,'index'])->name('materiel.index');

Route::get('/materiel/ajouter', [GestionMaterielController::class,'create'])->name('materiel.create');

Route::post('/materiels', [GestionMaterielController::class,'store'])->name('materiels.store');

Route::get('/materiels/{id}/edit', [GestionMaterielController::class,'edit'])->name('materiel.edit');

Route::put('/materiels/{id}', [GestionMaterielController::class,'update'])->name('materiel.update');

Route::delete('/materiels/{id}/{id2}', [GestionMaterielController::class,'destroy'])->name('materiel.destroy');

Route::get('/materiels/recherche', [GestionMaterielController::class,'search'])->name('materiel.search');

Route::get('/getFournisseurs', [GestionMaterielController::class,'getFournisseurs']);

/*********** UTILISATEUR ***********/
Route::get('/utilisateurs', [GestionUserController::class,'index'])->name('users.index');

Route::post('/utilisateurs', [GestionUserController::class,'store'])->name('users.store');

Route::get('/utilisateurs/{id}/edit', [GestionUserController::class,'edit'])->name('users.edit');

Route::put('/utilisateurs/{id}', [GestionUserController::class,'update'])->name('users.update');

Route::delete('/utilisateurs/{id}', [GestionUserController::class,'destroy'])->name('users.destroy');

Route::post('/utilisateurs/taches/{id}', [GestionUserController::class,'taches'])->name('users.taches');

/*********** PROFIL ***********/
Route::get('/administrateur/profil', [GestionUserController::class,'profil'])->name('users.profil');

Route::get('/administrateur/profil/editer/{id}', [GestionUserController::class,'editProfil'])->name('users.editProfil');

Route::put('/administrateur/profil/{id}', [GestionUserController::class,'updateProfil'])->name('users.updateProfil');

Route::get('/administrateur/profil/motDePasse', [GestionUserController::class,'changeMotDePasse'])->name('motDePasseAdmin');

Route::post('/administrateur/profil/motDePasse', [GestionUserController::class,'storeMotDePasse'])->name('storeMotDePasseAdmin');

/*********** PROJETS ***********/
Route::get('/projets',[GestionProjetController::class,'index'])->name('projets.index');

Route::post('/projets/create',[GestionProjetController::class,'create']);

Route::get('/projets/liste',[GestionProjetController::class,'liste'])->name('projets.liste');

Route::post('/projets/delete',[GestionProjetController::class,'destroy']);

Route::post('/projets/dateChange',[GestionProjetController::class,'dateChange']);

Route::get('/projets/{id}/edit',[GestionProjetController::class,'edit'])->name('projets.edit');

Route::put('/projets/{id}',[GestionProjetController::class,'update'])->name('projets.update');

Route::get('/projets/{id}/enCours', [GestionProjetController::class,'enCours'])->name('projets.enCours');

Route::get('/projets/{id}/terminé', [GestionProjetController::class,'terminé'])->name('projets.terminé');

/*********** Validation ***********/
Route::get('/articles/validation', [ArticleTacheController::class,'validation'])->name('articles.validation');

Route::get('/articles/validation/pasValidé/{id}', [ArticleTacheController::class,'pasValidé'])->name('articles.pasValidé');

Route::get('/articles/validation/validé/{id}', [ArticleTacheController::class,'validé'])->name('articles.validé');

Route::get('/materiels/validation', [MaterielAffectController::class,'validation'])->name('materiels.validation');

Route::get('/materiels/validation/pasValidé/{id}', [MaterielAffectController::class,'pasValidé'])->name('materiels.pasValidé');

Route::get('/materiels/validation/validé/{id}', [MaterielAffectController::class,'validé'])->name('materiels.validé');
/******************************************** USER ********************************************/

/*********** ARTICLETACHE (commande) ***********/
Route::get('/commandes', [ArticleTacheController::class,'index'])->name('commandes.index');

Route::get('/commande/ajouter', [ArticleTacheController::class,'create'])->name('commande.create');

Route::post('/commandes', [ArticleTacheController::class,'store'])->name('commande.store');

Route::get('/commandes/{id}/edit', [ArticleTacheController::class,'edit'])->name('commande.edit');

Route::get('/commandes/{id}/delete/{token}', [ArticleTacheController::class,'destroy'])->name('commande.destroy');

Route::delete('/commandes/{id}', [ArticleTacheController::class,'delete'])->name('commande.delete');


Route::post('/commandes/stock/{id}/{quantite}', [ArticleTacheController::class,'stock']);

Route::post('/commandes/taches/{id}', [ArticleTacheController::class,'taches'])->name('commandes.taches');

Route::post('/commandes/fournisseurs/{id}', [ArticleTacheController::class,'fournisseurs'])->name('commandes.fournisseurs');

/*********** UTILISATEUR ***********/
Route::get('/profil', [UserController::class,'profil'])->name('profil');

Route::get('/profil/motDePasse', [UserController::class,'changeMotDePasse'])->name('changeMotDePasse');

Route::post('/profil/motDePasse', [UserController::class,'storeMotDePasse'])->name('storeMotDePasse');



/*############################################### ABDELLAH ###############################################*/
Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
/*********** STOCK USER ABDEL***********/

Route::get('/stocks', [StockController::class,'showStock'])->name('stocks.show');

Route::get('/stocks/ajouter', [StockController::class,'addStock'])->name('stocks.add');

Route::post('/stocks', [StockController::class,'store'])->name('stocks.store');

Route::get('/stocks/recherche', [StockController::class,'search'])->name('stocks.cherche');

/**********************MATERIEL AFFECTATION USER ABDEL*****************/
Route::get('/affectation_materiel',[MaterielAffectController::class,'showMateriel'])->name('materiel.affect');

Route::get('/affectation_materiel/ajouter/{id}',[MaterielAffectController::class,'create'])->name('materiel.projet.add');

Route::post('/affectation_materiel',[MaterielAffectController::class,'store'])->name('materiel.projet.store');
