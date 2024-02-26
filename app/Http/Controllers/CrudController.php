<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teste;

class CrudController extends Controller
{
    public function index(Request $request)
    {
        return view('/dashboard');
    }

    public function store(Request $request)
    {
        Teste::create([
            'nome' => $request->nome,
            'email' => $request->email
        ]);

        return redirect('/dashboard')->with('success', 'Usuário registrado com sucesso');
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
            'nome' => $request->input('nome'),
            'email' => $request->input('email')
        ]);
        return redirect('/dashboard')->with('success', 'Usuário editado com sucesso');
    }

    public function destroy($id)
    {
        $usuario = Teste::find($id);
        if ($usuario) {
            $usuario->delete();
            return redirect('/dashboard')->with('success', 'Usuário excluído com sucesso');
        }
        return redirect('/dashboard')->with('error', 'Usuário não encontrado');
    }

    public function getUsersJson(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Teste::query();

        if ($searchTerm) {
            $query->where('id', 'like', "%$searchTerm%")
                ->orWhere('nome', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }

        $usuarios = $query->get(['id', 'nome', 'email']);

        return response()->json(['usuarios' => $usuarios]);
    }

    public function editByID(Request $request)
    {
        $searchID = $request->input('search_ID');
        
        $usuario = Teste::find($searchID);
        
        if (!$usuario) {
            return redirect('/dashboard')->with('error', 'Usuário não encontrado');
        }

        return view('editar', ['usuario' => $usuario]);
    }
}
