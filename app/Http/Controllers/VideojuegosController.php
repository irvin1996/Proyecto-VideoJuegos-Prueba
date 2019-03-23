<?php
//Siempre se ocupa poner este namespace para buscar y que la rutas los reconozca
namespace App\Http\Controllers;
//Esto para hacer referencia al archivo de video juegos
//estuctura para usar el use namespace + nombre del archivo
//Asi llamo al modelo
use App\Videojuego;
use App\Like;
use App\Plataforma;
use Auth;
use Gate;
Use App\Charts\Graficos;
Use DB;
Use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideojuegosController extends Controller
{



public function vjAdminCreate(Request $request)
    {
      $this->validate($request, [
          'nombre' => 'required|min:5',
          'descripcion' => 'required|min:10',
          'fechaEstrenoInicial' => 'required|date',
          'archivoImagen'=>'required|image'
      ]);
      //Guardar la imagen en el servidor
      $ruta=$request->file('archivoImagen')->store(
        'images','public'
      );
        $vj = new Videojuego([
          'nombre'=>$request->input('nombre'),
          'descripcion'=>$request->input('descripcion'),
          'fechaEstrenoInicial'=>$request->input('fechaEstrenoInicial'),
          'imagen'=>$ruta
        ]);
        $user=Auth::user()->id;
        $vj->user()->associate($user);
        $vj->save();
        $vj->plataformas()->attach($request->input('plataformas')===null ? []:$request->input('plataformas'));
        return redirect()
        ->route('admin.index')
        ->with('info', 'Videojuego: ' . $request->input('nombre').' creado');
    }


    public function getAdminIndex(){

      $videojuegos=Videojuego::orderby('nombre','asc');
      if (Gate::denies('see-all-vj')) {
        $videojuegos=$videojuegos->where('user_id',auth()->user()->id);
      }
      $videojuegos=$videojuegos->paginate(3);
      return view('Admin.index',['videojuegos'=>$videojuegos]);

    }

    public function getIndex(){
    $videojuegos=Videojuego::where('publicar',true)->orderby('created_at','desc')->paginate(2);
    return view('videojuego.index',['videojuegos'=>$videojuegos]);

    }

    public function getVideoJuego($id){
    $videojuego=Videojuego::where('id',$id)->with('likes')->first();
      return view('videojuego.videojuego',['vj'=>$videojuego]);
    }



    public function getLikeVideoJuego($id){
    $videojuego=Videojuego::where('id',$id)->first();
    $like=new Like();
    $videojuego->likes()->save($like);
    return redirect()->back();

    }


    public function getAdminEdit(VideoJuego $vj){
      $plataforma=Plataforma::all();
      $videojuego= Videojuego::find($vj->id);
      return view('admin.edit',['vj'=>$videojuego,'plataformas'=>$plataforma]);
    }


    public function vjAdminEditar(VideoJuego $vj,Request $request)
        {
          $this->validate($request, [
              'nombre' => 'required|min:5',
              'descripcion' => 'required|min:10',
              'fechaEstrenoInicial' => 'required|date'
          ]);
          $videojuego=Videojuego::find($request->input('id'));
          if (!($request->file('archivoImagen')===null) || !($request->file('archivoImagen')=="")) {
            Storage::disk('public')->delete($videojuego->imagen);

            $ruta=$request->file('archivoImagen')->store(
              'images','public'
            );
            $videojuego->imagen=$ruta;
          }


          $videojuego->nombre=$request->input('nombre');
          $videojuego->descripcion=$request->input('descripcion');
          $videojuego->fechaEstrenoInicial=$request->input('fechaEstrenoInicial');
          $videojuego->save();
          $videojuego->plataformas()->sync(
          $request->input('plataformas')===null?[]:$request->input('plataformas')
          );
            return redirect()
            ->route('admin.index')
            ->with('info', 'Videojuego: ' . $request->input('nombre').' creado');
        }

        public function getAdminCreate(){
          $plataforma=Plataforma::all();
          return view('admin.create',['plataformas'=>$plataforma]);
        }


        public function getSoftdeleteID($id){
            $videojuego= Videojuego::find($id);
            $videojuego->delete();
            return redirect()
            ->route('admin.index')
           ->with('info', 'Videojuego: ' .' Eliminado');
          }

public function publicar(Videojuego $vj){

  $vj->publicar=true;
  $vj->save();
  return back();

}

public function grafico($info="fei",$tipo="")
{
  $chart = new Graficos();

  if($info=="fei"){
    $titulo="Videojuegos por mes: Fecha Estreno Inicial";
    $vjs =Videojuego::select(DB::raw("MONTH(fechaEstrenoInicial) as mes")
,DB::raw("(COUNT(*)) as cantidad"))
->orderBy('fechaEstrenoInicial')
->groupby(DB::raw("MONTH(fechaEstrenoInicial)"))
->get();
$chart->labels($vjs->pluck('mes'));

    switch ($tipo) {
        case 'bar':
$dataset=$chart->dataset($titulo,'bar',$vjs->pluck('cantidad'));
          break;
        case 'pie':
$dataset=$chart->dataset($titulo,'pie',$vjs->pluck('cantidad'));
          break;
        case 'donut':
$dataset=$chart->dataset($titulo,'doughnut',$vjs->pluck('cantidad'));
          break;
        case 'line':
$dataset=$chart->dataset($titulo,'line',$vjs->pluck('cantidad'));
          break;
        case 'polarArea':
$dataset=$chart->dataset($titulo,'polarArea',$vjs->pluck('cantidad'));
          break;
        default:
        $dataset=$chart->dataset($titulo,'bar',$vjs->pluck('cantidad'));

        break;
    }
  }else{
    $titulo="Cantidad de Videojuegos por Plataforma";
$plataformas =Plataforma::orderby('nombre')->with('videojuegos')->get();
    $cantidades=[];

foreach ($plataformas as $plat ) {
  $cantidades[]=count($plat->videojuegos);
}
$chart->labels($plataformas->pluck('nombre'));

    switch ($tipo) {
        case 'bar':
        $dataset=$chart->dataset($titulo,'bar',$cantidades);
          break;
        case 'pie':
        $dataset=$chart->dataset($titulo,'pie',$cantidades);
          break;
        case 'donut':
        $dataset=$chart->dataset($titulo,'donut',$cantidades);
          break;
        case 'line':
        $dataset=$chart->dataset($titulo,'line',$cantidades);
          break;
        case 'radar':
        $dataset=$chart->dataset($titulo,'radar',$cantidades);
          break;
        default:
        $dataset=$chart->dataset($titulo,'bar',$cantidades);
        break;
    }
  }

  $dataset->backgroundColor(['#a9cce3', ' #a9dfbf', '#fad7a0','#c39bd3','#f9e79f','#a3e4d7', '#fadbd8', '#e59866']);
  $dataset->color(['#2980b9', '#52be80', '#f0b27a','#7d3c98', '#f4d03f','#48c9b0','#f1948a','#d35400']);

  return view('admin.grafico', ['chart' => $chart]);

}
public function descargarPDF($id){
  $vj = Videojuego::find($id);
  $pdf=PDF::loadView('admin.pdf-videojuego',compact('vj'));
  return $pdf->download('videojuego'.$id.'.pdf');

}


//Parte de las sessiones
/*

  public function getIndex(Store $session){
    //Vamos a crear instancias para traer los datos a partir del modelo

    //Creamos la instancia del modelo
    $instVJ= new Videojuego();
    $videojuegos=$instVJ->getVideoJuegos($session);
    return view('videojuego.index',['videojuegos'=>$videojuegos]);

  }
//Esto es lo nuevo, es para crearlo para el admin
  public function getAdminIndex(Store $session){
    //Vamos a crear instancias para traer los datos a partir del modelo

    //Creamos la instancia
    $instVJ= new Videojuego();
    $videojuegos=$instVJ->getVideoJuegos($session);

    return view('Admin.index',['videojuegos'=>$videojuegos]);

  }

//Traer solo un video juego
public function getVideoJuego(Store $session){
  //Vamos a crear instancias para traer los datos a partir del modelo
  //Creamos la instancia
  $instVJ= new Videojuego();
  $videojuego=$instVJ->getVideoJuego($session,$id);
  return view('videojuego.videojuego',['vj'=>$videojuego]);

}
public function getAdminEdit(Store $session,$id){

  $instVJ= new Videojuego();
  $videojuego=$instVJ->getVideoJuego($session,$id);
  return view('admin.edit',['vj'=>$videojuego,'vjId'=>$id]);
}

public function getAdminCreate(){
  return view('admin.create');
}
//Controlador para crear con la session
public function vjAdminCreate(Store $session, Request $request)
    {
      $this->validate($request, [
          'nombre' => 'required|min:5',
          'descripcion' => 'required|min:10',
          'fechaEstrenoInicial' => 'required|date'
      ]);
        $Videojuego = new Videojuego();
        $Videojuego->addVideojuego($session,
        $request->input('nombre'),
        $request->input('descripcion'),
        $request->input('fechaEstrenoInicial'));
        return redirect()
        ->route('admin.index')
        ->with('info', 'Videojuego: ' . $request->input('nombre').' creado');
    }

//Para Editar//Controlador para crear
public function vjAdminEditar(Store $session, Request $request)
    {
      $this->validate($request, [
          'nombre' => 'required|min:5',
          'descripcion' => 'required|min:10',
          'fechaEstrenoInicial' => 'required|date'
      ]);
        $Videojuego = new Videojuego();
        $Videojuego->editVideojuego($session,
        $request->input('id'),
        $request->input('nombre'),
        $request->input('descripcion'),
        $request->input('fechaEstrenoInicial'));
        return redirect()
        ->route('admin.index')
        ->with('info', 'Videojuego: ' . $request->input('nombre').' creado');
    }
 */


}
