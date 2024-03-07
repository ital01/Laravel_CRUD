<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teste;

class CrudController extends Controller
{
    public function index(Request $request)
    {
        $query = Teste::query();

        $limit = Teste::count();

        if ($request->has('searchById')) {
            $query->where('id', $request->searchById);
        }
        if ($request->has('searchByName')) {
            $query->where('nome', 'like', '%'.$request->searchByName.'%');
        }
        if ($request->has('searchByEmail')) {
            $query->where('email', 'like', '%'.$request->searchByEmail.'%');
        }
    
        $usuarios = $query->paginate($limit);
    
        return view('dashboard', ['usuarios' => $usuarios]);
    }

    /*public function search(Request $request)
    {
        $query = Teste::query();
    
        if ($request->has('searchById')) {
            $query->where('id', $request->searchById);
        }
        if ($request->has('searchByName')) {
            $query->where('nome', 'like', '%'.$request->searchByName.'%');
        }
        if ($request->has('searchByEmail')) {
            $query->where('email', 'like', '%'.$request->searchByEmail.'%');
        }
    
        $usuarios = $query->paginate();
    
        return view('dashboard', compact('usuarios'));
    }
    */
       

    public function store(Request $request)
    {
        Teste::create([
            'nome' => $request->nome,
            'email' => $request->email
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuário registrado com sucesso');
    }

    public function edit($id)
    {
        $usuario = Teste::find($id);

        return view('editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Teste::find($id);

        $usuario->update([
            'nome' => $request->nome,
            'email' => $request->email
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuário editado com sucesso');
    }

    public function destroy($id)
    {
        $usuario = Teste::find($id);

        if ($usuario) {
            $usuario->delete();
            return redirect()->route('dashboard')->with('success', 'Usuário excluído com sucesso');
        }

        return redirect()->route('dashboard')->with('error', 'Usuário não encontrado');
    }
}