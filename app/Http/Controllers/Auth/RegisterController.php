<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Address;
use App\UserAddress;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'email2' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //'phone' => ['required', 'numeric'],
            'gender' => 'required',
            //'address' => ['required', 'string'],
            //'city' => ['required', 'string'],
            //'state' => ['required', 'string'],
            //'zip' => ['required', 'numeric'],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'accept' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Funcion Recursiva para generar los codigos de productos y/o usuarios de forma aleatoria y no repetitivos
        function random_id(String $string) {
            $id1 = mt_rand(0000,9999);  // Entre el 0000 y el 9999
            $id = str_pad($id1, 4, "0", STR_PAD_LEFT);  // Siempre 4 digitos, sino completa con ceros (0)
            $users= User::all();
                foreach ($users as $user) {
                    if ($user->code == $string.$id) {
                        random_id($string);
                    }
                }
            return $string.$id;
        }

        $code = random_id('USER');   // Genera codigo aleatorio irrepetible

        $destinationPath = null;
        $name = null;

        // Verifica si existe archivo y lo mueve a la ruta destino
        if (isset($data['avatar'])) {
            $avatar = $data['avatar'];
            $name = md5(time() . $avatar->getClientOriginalName()) . '.' . $avatar->getClientOriginalExtension();
            //$name = $data->code.'_'.$data->name.'.'.$avatar->getClientOriginalExtension();
            $destinationPath = public_path('/storage/uploads');   // Ruta destino nuevo avatar
            $avatar->move($destinationPath, $name);
            //$avatar->save();   // save() solo sirve para Nuevas Instancias de clase, no para un archivo.
        }
        
        // Metodo estilo array
        $new_user = User::create([
            'user_type_id' => 2,
            'code' => $code,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'email2' => $data['email2'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'avatar' => 'uploads/' . $name,
        ]);

        if ($data['address'] != null || $data['city'] != null || $data['state'] != null || $data['zip'] != null) {
            // Metodo estilo array
            $new_address = Address::create([
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip' => $data['zip'],
            ]);

            // Metodo estilo array
            UserAddress::create([
                'address_id' => $new_address->id,  // Ultima (id) direccion de usuario recien creado
                'user_id' => $new_user->id,  // Ultimo (id) usuario recien creado
            ]);

        }

        \Session::flash('alert-success', 'Usuario Registrado Correctamente !!!');

        return redirect()->back()->with('message', 'Usuario Registrado Correctamente !!!'); // Vuelve a la pagina de donde vino con un mensaje

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'states' => \DB::table('states')->get()
        ]);
    }
}
