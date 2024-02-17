<?php 

require_once('vendor/autoload.php');

include 'index.php';

$spider = new SintegraSpider();

// CNPJs para testar
// $cnpjs = [
//     '00063744000155',
//     '00080160000198',
//     '00080782000116'
// ];



    $html = $spider->fetchData();
    $data = $spider->parseData($html);
    print_r($data);
    
?>