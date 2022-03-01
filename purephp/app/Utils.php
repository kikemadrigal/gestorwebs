<?php

function cortarCadena($cadena){
    //Strip_tags: retira las etiquetas HTML y PHP de un String
    //substr($cadena, corta inicio, corta final)
    //strlen: devuelve la longitud de la cadena
    $longitud = 20;
    $stringDisplay = substr(strip_tags($cadena), 0, $longitud);
    if (strlen(strip_tags($cadena)) > $longitud)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}

function formatearCadena($cadena){
    //$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
    //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
    $cadena=html_entity_decode($cadena);
    $cadena= str_replace(" ", "&nbsp;", $cadena);
    return $cadena;
}
function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
    $cadenaLimpia=trim($cadena);
    //$cadenaLimpia=urlencode($cadenaLimpia);
    return $cadenaLimpia;
}

?>