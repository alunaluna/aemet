<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;

class AemetHelper
{

	private $tiempo;

	function __construct()
	{

        //$response = Http::withHeaders([ //Meter la api key de aemet en el .ENV
        //    'api_key' => 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJncmFmZml0ZXJvbWFzQGdtYWlsLmNvbSIsImp0aSI6ImVkMThiMDM1LTdmYTgtNGQxYy1hNmY2LWQ4NDQ1Y2ZmZDM4ZCIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjA4NTcxNjE1LCJ1c2VySWQiOiJlZDE4YjAzNS03ZmE4LTRkMWMtYTZmNi1kODQ0NWNmZmQzOGQiLCJyb2xlIjoiIn0.US6H11IPALR5cqM5SsAK4Yc3XqblEv4t5RvkAFpRhA4'
        //])->get('https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/29067');

        //$url_tiempo = json_decode($response->getBody(),true)['datos'];

        //$response_tiempo = Http::get($url_tiempo);

        $response_tiempo = Http::get('https://opendata.aemet.es/opendata/sh/6be0a230');

        $tiempo = json_decode($response_tiempo->getBody(),true);

        dd($tiempo);

	}

    public function eventos(){
        return $this->eventos;
    }


    public function eventosDelMes($mes){
        $eventosMes = array();
        foreach($this->eventos as $e){
            $month = date("m",strtotime(str_replace('/', '-', $e['F_INICIO'])));
            if($month == $mes){
                $eventosMes[]=$e;
            }
        }
        return $eventosMes;
	}

    public function eventosPorNombre($fragmento){
        $eventosNombre = array();
        foreach($this->eventos as $e){
            $nombre = $e['NOMBRE'];
            if(strpos(strtolower($nombre), strtolower($fragmento)) !== false){
                $eventosNombre[]=$e;
            }
        }
        return response()->json($eventosNombre, 200);
    }

    public function eventosProximosWebs(){
        $hoy = new DateTime();
        $hoy = $hoy->getTimestamp();
        $eventos = $this->eventos;
        $webs = array();
        foreach($eventos as $e){
            $fecha = strtotime(str_replace('/', '-', $e['F_INICIO']));
            if($hoy <= $fecha && $e['DIRECCION_WEB'] != ''){
                $webs[]=[$e['NOMBRE'],$e['F_INICIO'],$e['DIRECCION_WEB']];
            }
        }
        return response()->json($webs, 200);
    }



    private function csvToArray($file) {
        $all_rows = array();
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $header = fgetcsv($handle);
            while ($row = fgetcsv($handle)) {
                $all_rows[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $all_rows;
    }

}
