<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Permite usar metodo table() en DB
use Illuminate\Support\Facades\File;

use App\User;
use App\UserType;
use App\UserAddress;
use App\Address;
use App\PaymentCard;
use App\Favorite;
use App\Cart;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $logued = \Auth::user();

        $states = DB::table('states')->get();

        return view('customer.profile.show', ['user' => $logued, 'states' => $states, 'mensaje' => null, 'pattern' => null]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $logued = \Auth::user();

        $states = DB::table('states')->get();

        return view('customer.profile.edit', ['user' => $logued, 'states' => $states, 'mensaje' => null, 'pattern' => null ]);

        //$pattern = '[A-Za-z0-9]{4,15}'; si se presiona cancelar, $pattern = ''.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Si se presiona "cancelar", sale de la ejecucion
        if (isset($request->cancelar)) {
            
            \Session::flash('alert-danger', 'Edición de Perfil Cancelada !!!');

            return redirect('/customer/profile')->with('message', 'Edición de Perfil Cancelada !!!'); // Vuelve a la pagina de donde vino con un mensaje

        }

        $logued = \Auth::user();

        $avatar_path = public_path('/storage/'.$logued->avatar); // Ruta al avatar del usuario
        $destinationPath = public_path('/storage/uploads');   // Ruta destino nuevo avatar

        // Verifica si existe archivo y lo mueve a la ruta destino
        if ($request->hasFile('avatar')) {

            // Si se envia una imagen, verifica si existe archivo anterior y lo elimina
            if ($logued->avatar !== null && File::exists($avatar_path)) {
                //File::delete($avatar_path);
                unlink($avatar_path);
            }

            $avatar = $request->file('avatar');
            //dd($avatar->getClientOriginalName());
            $name = md5(time() . $avatar->getClientOriginalName()) . '.' . $avatar->getClientOriginalExtension();
            //dd($name);
            //$name = $request->code.'_'.$request->name.'.'.$avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $name);
            //$avatar->save();   // save() solo sirve para Nuevas Instancias de clase, no para un archivo.
        
            // Actualiza TODOS los valores a traves de $request y luego vuelve a cambiar la ruta a la imagen
            $logued->update($request->all());
            $logued->avatar = 'uploads/'.$name;   // Nombre de la ruta que queda en la base de datos
            $logued->save();

        } else {
            // Si no hay avatar, actualiza el resto
            $logued->update($request->all());
        }

        \Session::flash('alert-warning', 'Perfil Editado Exitosamente !!!');

        return redirect('/customer/profile')->with('message', 'Perfil Editado Exitosamente !!!'); // Vuelve a la pagina de donde vino con un mensaje

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar != null) {
            
            $image_path = public_path('storage/'.$user->avatar); // Ruta al archivo del user

            // Verifica si existe archivo de imagen y lo elimina
            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
            }
        }

        $user->delete();

        \Session::flash('alert-danger', 'Usuario Eliminado Exitosamente !!!');

        return redirect()->back()->with('message', 'Usuario Eliminado Exitosamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    public function list()
    {
        $users = User::paginate(5);

        return view('admin.users.list', ['users' => $users]);
    }

    public function listar() {
        // Read File

        $jsonString = file_get_contents(base_path('json/users.json'));

        $data = json_decode($jsonString, true);

        dd($data);
    }
}
