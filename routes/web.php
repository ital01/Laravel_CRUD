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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $searchTerm = $request->input('search');
        $limit = $request->query('limit', 100);

        $query = Teste::query();

        if ($searchTerm) {
            $query->where('id', 'like', "%$searchTerm%")
                ->orWhere('nome', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }

        $usuarios = $query->paginate($limit);

        return view('dashboard', ['usuarios' => $usuarios]);
    })->middleware(['auth', 'verified'])->name('dashboard');


    Route::post('/enviar-form', function (Request $dados) {
        Teste::create([
            'nome' => $dados->nome,
            'email' => $dados->email
        ]);
        return redirect('/dashboard')->with('success', 'Usuário registrado com sucesso');
    });

    Route::get('/dashboard/editar/{id}', function ($id) {
        $usuario = Teste::find($id);
        return view('editar', compact('usuario'));
    })->name('editar');

    Route::get('/dashboard/atualizar/{id}', function (Request $request, $id) {
        $usuario = Teste::find($id);
        $usuario->update([
            'nome' => $request->query('nome'),
            'email' => $request->query('email')
        ]);
        return redirect('/dashboard')->with('success', 'Usuário editado com sucesso');
    })->name('atualizar');

    Route::delete('/dashboard/excluir/{id}', function ($id) {
        $usuario = Teste::find($id);
        if ($usuario) {
            $usuario->delete();
            return redirect('/dashboard')->with('success', 'Usuário excluído com sucesso');
        }
        return redirect('/dashboard')->with('error', 'Usuário não encontrado');
    })->name('excluir');

    Route::get('/search', function (Request $request) {
        $searchTerm = $request->input('search');
        $limit = $request->query('limit', 100);

        $query = Teste::query();

        if ($searchTerm) {
            $query->where('id', 'like', "%$searchTerm%")
                ->orWhere('nome', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }

        $usuarios = $query->paginate($limit);

        return view('dashboard', ['usuarios' => $usuarios]);
    })->middleware(['auth', 'verified'])->name('search');
});

Route::get('/dashboard', function () {
    $usuarios = Teste::paginate(10);
    return view('dashboard', ['usuarios' => $usuarios]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
