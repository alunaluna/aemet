
let campo_foto, foto, campo_ubicacion, boton_lugar, mapa, latitud_form, longitud_form, marker;

function init(){
    /*campo_foto = document.getElementById("url_foto");
    campo_foto.addEventListener('change', mostrarFoto);

    foto = document.getElementById("imagen_mostrar");
*/
    campo_ubicacion = document.getElementById("lugar");

    boton_lugar = document.getElementById("check_sitio");
    boton_lugar.addEventListener('click', actualizarMapa);

    window.addEventListener('LaravelMaps:MapInitialized', function (event){
      mapa = event.detail.map;
    })

    latitud_form = document.getElementById("latitud");
    longitud_form = document.getElementById("longitud");

    marker = new L.marker([0, 0])
}

init();
/*
function mostrarFoto(){
    let url = campo_foto.value;
    foto.src = url;
}*/

function actualizarMapa(){
    let ubicacion = campo_ubicacion.value;
    let json;
    fetch("https://nominatim.openstreetmap.org/search.php?q="+ubicacion+"&format=jsonv2").then(res=>res.json()).then((out)=> {
        json = out;
        let latitud = json[0]['lat'];
        let longitud = json[0]['lon'];
        mapa.setView([latitud, longitud], 30);

        mapa.removeLayer(marker);
        marker = new L.marker([latitud, longitud]);
        mapa.addLayer(marker);

        latitud_form.value = latitud;
        longitud_form.value = longitud;
    });
    //
}
