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
    
        $usuarios = $query->paginate($limit);
    
        return view('dashboard', ['usuarios' => $usuarios]);
    }
       
    
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