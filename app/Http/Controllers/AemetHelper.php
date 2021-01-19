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
        //    'api_key'=> 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJncmFmZml0ZXJvbWFzQGdtYWlsLmNvbSIsImp0aSI6ImVkMThiMDM1LTdmYTgtNGQxYy1hNmY2LWQ4NDQ1Y2ZmZDM4ZCIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjA4NTcxNjE1LCJ1c2VySWQiOiJlZDE4YjAzNS03ZmE4LTRkMWMtYTZmNi1kODQ0NWNmZmQzOGQiLCJyb2xlIjoiIn0.US6H11IPALR5cqM5SsAK4Yc3XqblEv4t5RvkAFpRhA4'
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

        $string = curl_exec($ch2);

        $tamstring = strlen($string);

        $stringWindows1252 = substr($string, 2,$tamstring - 4);

        //TIPICO FALLO DE CODIFICACION QUE HACE QUE EL JSON_DECODE DEVUELVA SIEMPRE NULL, PORQUE EL STRING ESTA
        // CODIFICADO EN WINDOWS-1252, SOLUCIONADO CON EL SIGUIENTE METODO
        $stringUTF8 = mb_convert_encoding($stringWindows1252, 'Windows-1252', 'UTF-8');

        $this->tiempo = json_decode($stringUTF8,true);

        curl_close($ch2);

        //TRATAMOS LOS DATOS PARA PREPARARLOS PARA SU PRESENTACIÓN
        $horaActual=date('H') + 1;
        for ($i = 0; $i <= 6; $i++) {
            $this->setFecha($i);
            $estadoCielo = $this->setEstadoCielo($i, $horaActual);
            $this->setTiempoIcono($i,$estadoCielo, $horaActual);
        }
	}

    public function tiempo(){
        return $this->tiempo;
    }

    public function tiempoHoy(){
        return $this->tiempo['prediccion']['dia'][0];
    }

    public function prediccionesProximaSemana(){

        $prediccionesProxSem = array();

        for ($i = 1; $i <= 6; $i++) {
            $prediccionesProxSem[] = $this->tiempo['prediccion']['dia'][$i];
        }

        return $prediccionesProxSem;
    }

    private function setFecha(int $indiceDia){

        $date = strtotime($this->tiempo['prediccion']['dia'][$indiceDia]['fecha']);

        switch(date('w', $date)){
            case 1: $diaSemana="Lunes";
                break;
            case 2: $diaSemana="Martes";
                break;
            case 3: $diaSemana="Miérc.";
                break;
            case 4: $diaSemana="Jueves";
                break;
            case 5: $diaSemana="Viernes";
                break;
            case 6: $diaSemana="Sábado";
                break;
            case 0: $diaSemana="Domin.";
                break;
        }

        $fechaFormateada =  $diaSemana." ".date('d', $date);
        $this->tiempo['prediccion']['dia'][$indiceDia]['fecha'] = $fechaFormateada;

    }


    private function setEstadoCielo(int $indiceDia, int $horaActual)
    {
        if($indiceDia == 0) {
            do{

                if ($horaActual >=1 && $horaActual<6 ) {
                    $indiceFranjaTemporal = 3;

                } elseif ($horaActual >=6 && $horaActual<12) {
                    $indiceFranjaTemporal = 4;

                } elseif ($horaActual >=12 && $horaActual<18) {
                    $indiceFranjaTemporal = 5;

                } else {
                    $indiceFranjaTemporal = 6;
                }

                $estadoCielo = strtolower($this->tiempo['prediccion']['dia'][$indiceDia]['estadoCielo'][$indiceFranjaTemporal]['descripcion']);
                $horaActual += 6;
            }while(empty($estadoCielo));
        }else {
            $estadoCielo = strtolower($this->tiempo['prediccion']['dia'][$indiceDia]['estadoCielo'][0]['descripcion']);
        }

        return $estadoCielo;
    }

    private function setTiempoIcono(int $indiceDia , string $estadoCielo, int $horaActual){

        $tiempoIcono = 'fas fa-question'; //icono Default

        if(strpos($estadoCielo, 'despejado') !== false || strpos($estadoCielo, 'nubes altas') !== false){
            if($indiceDia == 0){
                if($horaActual > 6 && $horaActual < 19){
                    $tiempoIcono = 'far fa-sun';
                }else{
                    $tiempoIcono = 'far fa-moon';
                }
            }else{
                $tiempoIcono = 'far fa-sun';
            }
        }elseif(strpos($estadoCielo, 'tormenta') !== false){
            $tiempoIcono = 'fas fa-bolt';
        }elseif(strpos($estadoCielo, 'niebla') !== false){
            $tiempoIcono = 'fas fa-smog';
        }elseif(strpos($estadoCielo, 'muy nuboso con lluvia') !== false ||
            strpos($estadoCielo, 'cubierto con lluvia') !== false){
            $tiempoIcono = 'fas fa-cloud-showers-heavy';
        }elseif(strpos($estadoCielo, 'cubierto') !== false || strpos($estadoCielo, 'muy nuboso') !== false){
            $tiempoIcono = 'fas fa-cloud';
        }elseif(strpos($estadoCielo, 'lluvia') !== false){
            if($indiceDia == 0){
                if($horaActual > 6 && $horaActual < 19){
                    $tiempoIcono = 'fas fa-cloud-sun-rain';
                }else{
                    $tiempoIcono = 'fas fa-cloud-moon-rain';
                }
            }else{
                $tiempoIcono = 'fas fa-cloud-sun-rain';
            }
        }elseif(strpos($estadoCielo, 'nuboso') !== false){
            if($indiceDia == 0){
                if($horaActual > 6 && $horaActual < 19){
                    $tiempoIcono = 'fas fa-cloud-sun';
                }else{
                    $tiempoIcono = 'fas fa-cloud-moon';
                }
            }else{
                $tiempoIcono = 'fas fa-cloud-sun';
            }
        }

        $this->tiempo['prediccion']['dia'][$indiceDia]['tiempoIcono'] = $tiempoIcono;

    }

}
