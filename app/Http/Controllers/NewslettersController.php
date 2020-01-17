<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Newsletter; // Permite usar el Model Newsletter

class NewslettersController extends Controller
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
        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }

        // Este metodo crea una nueva instancia del tipo Newsletter
        $newsletter = ['newsletter' => new Newsletter, /*'msg' => $msg*/];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Esto valida si los datos estan completos, sino redirige a la pagina de origen !!!
        $this->validate($request, [
            'email' => 'required',
        ]);

        // Se invoca al metodo create($array) para guardar un nuevo registro
        $newsletter = Newsletter::create($request->all());
        //$newsletter = new Newsletter(['email' => $request->email]);
        //$newsletter->save();
        \Session::flash('alert-success', 'Subscripción Exitosa !!!');
        return redirect('/')->with('message', 'Subscripción Exitosa !!!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
