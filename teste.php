<?php

namespace Facebook\WebDriver; 
use Facebook\WebDriver\Remote\DesiredCapabilities; 
use Facebook\WebDriver\Remote\RemoteWebDriver; 

header("Content-type: text/html; charset=utf-8");

require_once('vendor/autoload.php'); 

$serverUrl = 'http://localhost:4444/wd/hub';

$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

$driver->get('http://www.sintegra.fazenda.pr.gov.br/sintegra/');

$driver->findElement(WebDriverBy::id('Sintegra1CodImage')) 
    ->sendKeys('');


$driver->findElement(WebDriverBy::id('imgSintegra'))->getAttribute('src');

echo  $captcha = 'Informe o texto da imagem: ';

$driver->findElement(WebDriverBy::id('Sintegra1CodImage'))->sendKeys($captcha);

$driver->findElement(WebDriverBy::id('btnConsultar'))->click();

$driver->quit();