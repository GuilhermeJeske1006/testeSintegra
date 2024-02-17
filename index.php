<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class SintegraSpider {
    private $url = 'http://www.sintegra.fazenda.pr.gov.br/sintegra/';

    public function fetchData() {
        $serverUrl = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

        $driver->get($this->url);

        $driver->findElement(WebDriverBy::id('Sintegra1CodImage'))->sendKeys('');

        // Encontrar a imagem do captcha
        $driver->findElement(WebDriverBy::id('imgSintegra'))->getAttribute('src');

        $captchaText = readline('Informe o texto da imagem (captcha): ');

        $cnpjText = readline('Informe o CNPJ: ');

        $driver->findElement(WebDriverBy::id('Sintegra1Cnpj')) 
            ->sendKeys($cnpjText);
        
        $driver->findElement(WebDriverBy::id('Sintegra1CodImage')) 
            ->sendKeys($captchaText);

        $driver->findElement(WebDriverBy::id('empresa'))->click();

        sleep(5);

        $html = $driver->getPageSource();

        $driver->quit();

        return $html;
    }

    public function parseData($html) {
        $pattern = '/<td class="form_conteudo">(.*?)<\/td>/s';
        preg_match_all($pattern, $html, $matches);

        $data = [];
        foreach ($matches[1] as $match) {
            $data[] = strip_tags(trim($match));
        }

        return $data;
    }
}

