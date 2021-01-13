<?php

namespace App\Http\Controllers;

use DateTime;
use GuzzleHttp\Client;

class DatosAbiertosHelper
{

	private $eventos;

	function __construct()
	{
		$client = new Client();

        $response = $client->request('GET', 'https://datosabiertos.malaga.eu/api/action/package_show?id=agenda-2020');
        $json_package = json_decode($response->getBody(),true);
		$url = $json_package['result']['resources'][0]['url'];
		$this->eventos = $this->csvToArray($url);
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
