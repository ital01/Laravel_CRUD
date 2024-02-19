<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Teste;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $searchTerm = $request->input('search');

    if ($searchTerm) {
        $usuarios = Teste::where('id', 'like', "%$searchTerm%")
            ->orWhere('nome', 'like', "%$searchTerm%")
            ->orWhere('email', 'like', "%$searchTerm%")
            ->get();
    } else {
        $usuarios = Teste::all();
    }

    return view('welcome', ['usuarios' => $usuarios]);
})->name('search');;

Route::middleware(['auth'])->group(function () {
    Route::post('/enviar-form', function (Request $dados) {
        Teste::create([
            'nome' => $dados->nome,
            'email' => $dados->email
        ]);
        return redirect('/')->with('success', 'Usuário registrado com sucesso');
    });

    Route::get('/editar/{id}', function ($id) {
        $usuario = Teste::find($id);
        return view('editar', compact('usuario'));
    })->name('editar');

    Route::get('/atualizar/{id}', function (Request $request, $id) {
        $usuario = Teste::find($id);
        $usuario->update([
            'nome' => $request->query('nome'),
            'email' => $request->query('email')
        ]);
        return redirect('/')->with('success', 'Usuário editado com sucesso');
    })->name('atualizar');

    Route::delete('/excluir/{id}', function ($id) {
        $usuario = Teste::find($id);
        if ($usuario) {
            $usuario->delete();
            return redirect('/')->with('success', 'Usuário excluído com sucesso');
        }
        return redirect('/')->with('error', 'Usuário não encontrado');
    })->name('excluir');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
