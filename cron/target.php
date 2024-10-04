<?php
    $misget = $_SERVER['argv'];
    $url = $misget[1];
    $datos = $misget[2];
    $dataArray = array(
        "id"        =>  $datos
    );
    $data = http_build_query($dataArray);
    $getUrl = $url."?".$data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    
    $response = curl_exec($ch);
    
    curl_close($ch);
?>