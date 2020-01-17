<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserType;

class UserTypeController extends Controller
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
        return view('admin.users.user_type.create', ['user_type' => new UserType,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);

        $user_type = UserType::Create($request->all());

        return redirect()->back(); // Vuelve a la pagina de donde vino
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_type = UserType::findOrFail($id);

        return view('admin.users.user_type.edit', ['user_type' => $user_type,]);
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
        $user_type = UserType::find($id);

        $user_type->update($request->all());

        return redirect()->back(); // Vuelve a la pagina de donde vino
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_type = UserType::findOrFail($id);

        $user_type->delete();

        \Session::flash('alert-danger', 'Rol de Usuario Eliminado Exitosamente !!!');

        return redirect()->back()->with('message', 'Rol de Usuario Eliminado Exitosamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    public function list()
    {
        $user_type = UserType::all();

        return view('admin.users.user_type.list', ['user_type' => $user_type]);
    }
}
