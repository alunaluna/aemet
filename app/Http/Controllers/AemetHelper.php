<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;

class AemetHelper
{

	private $tiempo;

	function __construct()
	{

	    //FORMA FÁCIL QUE NO FUNCIONA

        //$response = Http::withHeaders([ //Meter la api key de aemet en el .ENV
        //    'api_key' => 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJncmFmZml0ZXJvbWFzQGdtYWlsLmNvbSIsImp0aSI6ImVkMThiMDM1LTdmYTgtNGQxYy1hNmY2LWQ4NDQ1Y2ZmZDM4ZCIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjA4NTcxNjE1LCJ1c2VySWQiOiJlZDE4YjAzNS03ZmE4LTRkMWMtYTZmNi1kODQ0NWNmZmQzOGQiLCJyb2xlIjoiIn0.US6H11IPALR5cqM5SsAK4Yc3XqblEv4t5RvkAFpRhA4'
        //])->get('https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/29067');

        //$url_tiempo = json_decode($response->getBody(),true)['datos'];

        //$response_tiempo = Http::get($url_tiempo);

        //$tiempo = json_decode($response_tiempo->getBody(),true);

        //dd($tiempo);

        //cURL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        $ch1 = curl_init();
        $headers = array(
            'api_key: eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJncmFmZml0ZXJvbWFzQGdtYWlsLmNvbSIsImp0aSI6ImVkMThiMDM1LTdmYTgtNGQxYy1hNmY2LWQ4NDQ1Y2ZmZDM4ZCIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjA4NTcxNjE1LCJ1c2VySWQiOiJlZDE4YjAzNS03ZmE4LTRkMWMtYTZmNi1kODQ0NWNmZmQzOGQiLCJyb2xlIjoiIn0.US6H11IPALR5cqM5SsAK4Yc3XqblEv4t5RvkAFpRhA4'
        );
        curl_setopt($ch1, CURLOPT_URL, 'https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/29067');
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch1, CURLOPT_HEADER, 0);
        curl_setopt($ch1, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);

        // execute
        //$output = curl_exec($ch1);

        $url_tiempo = json_decode(curl_exec($ch1),true)['datos'];

        // free
        curl_close($ch1);


        $ch2 = curl_init();
        $headers = array(
            'api_key: eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJncmFmZml0ZXJvbWFzQGdtYWlsLmNvbSIsImp0aSI6ImVkMThiMDM1LTdmYTgtNGQxYy1hNmY2LWQ4NDQ1Y2ZmZDM4ZCIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjA4NTcxNjE1LCJ1c2VySWQiOiJlZDE4YjAzNS03ZmE4LTRkMWMtYTZmNi1kODQ0NWNmZmQzOGQiLCJyb2xlIjoiIn0.US6H11IPALR5cqM5SsAK4Yc3XqblEv4t5RvkAFpRhA4'
        );
        curl_setopt($ch2, CURLOPT_URL, $url_tiempo);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch2, CURLOPT_HEADER, 0);
        curl_setopt($ch2, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);

        // execute
        //$output = curl_exec($ch2);

        $tiempo = json_decode(curl_exec($ch2),true);


        // free
        curl_close($ch2);

        //dd($output);

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
