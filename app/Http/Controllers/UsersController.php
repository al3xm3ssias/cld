<?php

namespace App\Http\Controllers;

;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use finfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    //

    public function index(){

    $usuarios = User::paginate();

        return view('usuario.index', compact('usuarios'))
            ->with('i', (request()->input('page', 1) - 1) * $usuarios->perPage());
    }

    public function create(){

        $usuarios = new User();
        return view('usuario.create', compact('usuarios'));

    }

    public function store(Request $request){

        request()->validate(User::$rules_create);

        $usuarios = User::create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso com sucesso.');

    }

    public function edit($id){

        $user = User::find($id);
        return view('usuario.edit', compact('user'));

    }



    public function update(Request $request, User $user, $id){

        $this->validate($request,[

            'email' => "required|max:255|unique:users,email,$id",
            'password' => 'nullable',

        ]);


        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));



    return redirect()->route('users.index')
    ->with('success', 'Usuário editado com sucesso.');


    }

    public function destroy(Request $request, $id)
        {

           $id = $request['user_id'];

           //$id = $this->$id->find($id);

           $id = User::find($id);

           $delete = $id->delete();

            if($delete){
                return redirect()->route('users.index')->with('sucess', 'Usuário excluido');
            }
            else
            return redirect()->route('users.index')->with('error', 'erri');

    }
}
