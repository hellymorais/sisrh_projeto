<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        if(Gate::allows('type-user')){
        $usuarios = User::all()->sortBy('name');
        return view('usuarios.index', compact('usuarios'));
        }else{
            return back();
        }
    }


    public function create()
    {
        if(Gate::allows('type-user')){
        $user = new User();
        return view('usuarios.create');
        }
    }

    public function store(Request $request)
    {
        $input = $request->toArray();
        $input['password'] = bcrypt($input['password']); // Linha que criptografa a senha do usuário com o método bcrypt, antes de guardar no banco

        // Insert de dados do usuário no banco
        User::create($input);

        return redirect()->route('usuarios.index')->with('sucesso','Usuário Cadastrado com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::find($id);

        if(!$usuario) {
            return back();
        }

        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $user->name = $request->input('name');

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->fill($input);
        $user->save();

        $user->tipo = $request->input('tipo');
        $user->save();

        if($input['type'] =="admin"){
        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário alterado com sucesso!');
        }else{
            return redirect()->route('usuarios.index', $user->id)->with('sucesso', 'Usuário alterado com sucesso!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário excluido com sucesso.');
    }
}
