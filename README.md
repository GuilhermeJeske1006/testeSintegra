# Web Crawler para o Sintegra do Paraná

O projeto consiste em criar um web crawler (também conhecido como 'spider') para extrair informações do Sintegra do Paraná. O Sintegra é um sistema que reúne dados sobre inscrições estaduais de contribuintes, utilizado para consultas relacionadas a operações de comércio interestadual.

O web crawler foi desenvolvido utilizando as bibliotecas Selenium e Facebook\WebDriver\WebDriverBy, com implementações em Java e PHP.

## Inicialização

Antes de iniciar o projeto, é necessário executar o servidor Selenium utilizando o seguinte comando:

```bash
java -jar selenium-server-standalone-3.4.0.jar
```

Posteriormente, no terminal, execute o comando a seguir para iniciar o sistema:

```bash
php testeSpider.php
```

## Funcionamento

Ao iniciar o sistema, o terminal solicitará o texto da imagem do captcha. Após inserir o texto, será requisitado o CNPJ a ser consultado.

Uma vez que o usuário fornece os dados solicitados, o programa realiza uma varredura em todas as possíveis inscrições estaduais associadas a um mesmo CNPJ. Em seguida, os dados são armazenados em um array para posterior análise ou processamento.

![image](https://github.com/GuilhermeJeske1006/testeSintegra/assets/97289331/a914dda4-1757-45bb-bb5c-5c8e0d4bae19)

