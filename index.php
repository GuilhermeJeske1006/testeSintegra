<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class SintegraSpider {
    private $url = 'http://www.sintegra.fazenda.pr.gov.br/sintegra/';
    private $driver;

    public function __construct() {
        $serverUrl = 'http://localhost:4444/wd/hub';
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
    }

    public function fetchData() {
        $this->driver->get($this->url);

        $this->enterCaptchaAndCNPJ();

        $data = $this->fetchDataFromPages();

        $this->driver->quit();

        return $data;
    }

    private function enterCaptchaAndCNPJ() {
        try {
            $this->driver->findElement(WebDriverBy::id('Sintegra1CodImage'))->sendKeys('');
            $this->driver->findElement(WebDriverBy::id('imgSintegra'))->getAttribute('src');
    
            $captchaText = readline('Informe o texto da imagem (captcha): ');
            $cnpjText = readline('Informe o CNPJ: ');
    
            $this->driver->findElement(WebDriverBy::id('Sintegra1Cnpj'))->sendKeys($cnpjText);
            $this->driver->findElement(WebDriverBy::id('Sintegra1CodImage'))->sendKeys($captchaText);
            $this->driver->findElement(WebDriverBy::id('empresa'))->click();

        } catch (\Facebook\WebDriver\Exception\WebDriverException $e) {
           print_r('Inscrição CNPJ Inválida.');
           $this->driver->quit();
           return;
        }
       
        
    }

    private function fetchDataFromPages() {
        $data = [];
    
        while (true) {
            $consultarButton = $this->driver->findElements(WebDriverBy::id('consultar'));
            if (count($consultarButton) > 0) {
                $consultarButton[0]->click();
                $html = $this->driver->getPageSource();
    
                if (empty($html)) {
                    return [
                        'Ocorreu um erro ao obter os dados. Por favor, tente novamente.'
                    ];
                }
    
                $parsedData = $this->parseData($html);
                if (!empty($parsedData)) {
                    $data[] = $parsedData;
                }
            } else {
                break;
            }
        }
    
        return $data;
    }
    

    private function parseData($html) {
        $pattern = '/<td class="form_conteudo">(.*?)<\/td>/s';
        preg_match_all($pattern, $html, $matches);

        $data = [];

        if (isset($matches[1])) {
            $data = [
                'cnpj' => isset($matches[1][0]) ? strip_tags(trim($matches[1][0])) : '',
                'ie' => isset($matches[1][1]) ? strip_tags(trim($matches[1][1])) : '',
                'numero' => isset($matches[1][2]) ? strip_tags(trim($matches[1][2])) : '',
                'uf' => isset($matches[1][3]) ? strip_tags(trim($matches[1][3])) : '',
                'cep' => isset($matches[1][4]) ? strip_tags(trim($matches[1][4])) : '',
                'inicio_atividade' => isset($matches[1][8]) ? strip_tags(trim($matches[1][8])) : '',
                'situacao_atual' => isset($matches[1][9]) ? strip_tags(trim($matches[1][9])) : '',
                'regime_tributario' => isset($matches[1][10]) ? strip_tags(trim($matches[1][10])) : '',
                'atividades' => [
                    'Atividade_principal' => isset($matches[1][5]) ? strip_tags(trim($matches[1][5])) : '',
                    'atvidade_segundaria' => isset($matches[1][6]) ? strip_tags(trim($matches[1][6])) : '',
                ]
            ];
        }

        return $data;
    }
}

?>
