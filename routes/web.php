<?php

use Illuminate\Http\Request;
use App\Models\Teste;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Rotas do dashboard
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

    Route::get('/dashboard-search', function (Request $request) {
        $searchID = $request->input('search_ID');
    
        $usuario = Teste::where('id', $searchID)->first();
    
        if (!$usuario) {
            return redirect('/dashboard')->with('error', 'Usuário não encontrado');
        }
    
        return view('dashboard', ['usuarios' => collect([$usuario])]);
    })->middleware(['auth', 'verified'])->name('dashboard.search');

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
    
        $query = Teste::query();
    
        if ($searchTerm) {
            $query->where('id', 'like', "%$searchTerm%")
                ->orWhere('nome', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }
    
        $usuarios = $query->paginate();
    
        return view('dashboard', ['usuarios' => $usuarios]);
    })->middleware(['auth', 'verified'])->name('search');
    
});

Route::get('/dashboard/usuarios-json', function () {
    $usuarios = Teste::all(['id', 'nome', 'email']);

    return Response::json([
        'usuarios' => $usuarios
    ]);
});

Route::get('/dashboard/usuarios-json', function (Request $request) {
    $searchTerm = $request->input('search');
    
    $query = Teste::query();
    
    if ($searchTerm) {
        $query->where('id', 'like', "%$searchTerm%")
            ->orWhere('nome', 'like', "%$searchTerm%")
            ->orWhere('email', 'like', "%$searchTerm%");
    }
    
    $usuarios = $query->get(['id', 'nome', 'email']);
    
    return Response::json([
        'usuarios' => $usuarios
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
