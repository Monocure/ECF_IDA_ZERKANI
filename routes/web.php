<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\CommentController;

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


// Route de la page d'accueil
Route::get('/', function () {
  $animes = DB::select("SELECT * FROM animes");
  return view('welcome', ["animes" => $animes]);
});

// Route de la page de l'anime
Route::get('/anime/{id}', function ($id) {
  $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
  return view('anime', ["anime" => $anime]);
});

// Route de la page de commentaire/notation de l'anime
Route::get('/anime/{id}/new_review', function ($id) {
  $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
  return view('new_review', ["anime" => $anime]);
});

// Ajouts du commentaire et de la note dans la base de donnée
Route::post('/anime/{id}/new_review', [CommentController::class, 'addCritic']);


// Route de la page de connexion
Route::get('/login', function () {
  return view('login');
});

// Autenthification
Route::post('/login', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
  ]);
  if (Auth::attempt($validated)) {
    return redirect()->intended('/');
  }
  return back()->withErrors([
    'username' => 'The provided credentials do not match our records.',
  ]);
});

// Route de la page d'inscription
Route::get('/signup', function () {
  return view('signup');
});

// Validation de l'inscription
Route::post('signup', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
    "password_confirmation" => "required|same:password"
  ]);
  $user = new User();
  $user->username = $validated["username"];
  $user->password = Hash::make($validated["password"]);
  $user->save();
  Auth::login($user);

  return redirect('/');
});

// Deconnexion
Route::post('signout', function (Request $request) {
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect('/');
});
