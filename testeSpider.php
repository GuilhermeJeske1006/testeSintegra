<?php 

require_once('vendor/autoload.php');

include 'index.php';

$spider = new SintegraSpider();
$dataArray = $spider->fetchData();

if (empty($dataArray)) {
    echo "O NúMERO DE CONTROLE DIGITADO NO CAPTCHA NãO CORRESPONDE AO NúMERO APRESENTADO NA IMAGEM.\n";
} else {
    echo "Dados do CNPJ\n";
    print_r($dataArray);
}
?>

