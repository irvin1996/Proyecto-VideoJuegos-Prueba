<?php

namespace App\Http\Controllers;
use App\Plataforma;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use App\http\Requests;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $plataforma = Plataforma::orderBy('nombre', 'desc')->paginate(10);
      return view('plataforma.index',compact('plataforma'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = array(
          'nombre' => 'required'
        );
      $validator = Validator::make ( Input::all(), $rules);
      if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
      else {
        $plataforma = new Plataforma;
        $plataforma->nombre = $request->nombre;
        $plataforma->save();
        return response()->json($plataforma);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $plataforma = Plataforma::find ($request->id);
      $plataforma->nombre = $request->nombre;
      $plataforma->save();
      return response()->json($plataforma);
    }

}
