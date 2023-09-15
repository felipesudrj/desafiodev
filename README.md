# desafiodev
Desafio de desenvolvimento backend - Endpoint para transferência financeira
Projeto desenvolvido usando o framework CAKEPHP

## Descrição do desafio realizado

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar somente ao fluxo de transferência entre dois usuários.

*Requisitos:*

Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

Lojistas só recebem transferências, não enviam dinheiro para ninguém.

Validar se o usuário tem saldo antes da transferência.

Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).

Este serviço deve ser RESTFul.


## solução realizada ----- segue instruções ---- ####



## Ambiente
1. Faça o download do projeto (https://github.com/felipesudrj/desafiodev)

2. Abre o diretório app No seu ambiente PHP execute o comando ´´´composer install´´´ para instalar as dependências do projeto

3. Você precisará configurar o arquivo .env com a conexão para seu banco de dados. Você deverá criar o arquivo .env dentro de app/config e colocar nesse arquivo as seguintes informações.

```
export APP_NAME="desafio"
export DEBUG="true"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="pt_BR"
export APP_DEFAULT_TIMEZONE="UTC"
export SECURITY_SALT="NO1872EBI8SD7FBI8W7BI8SFIU7DTFB8D"
export DATABASE_URL="mysql://root:root@localhost/${APP_NAME}?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"
```

4. Rodar o comando migrate para estruturar o banco de dados do projeto

```bash
bin/cake migrations migrate
```

## Rodando o projeto
Você precisa rodar o seguinte comando para iniciar um servidor local através do CAKEPHP, o CAKEPHP possui o BAKE muito similar aos comandos do Artisan no laravel, muda algumas coisas na sintaxe.

```bash
bin/cake server -p 8765
```

Esse é o endpoint da aplicação: 

```bash
http://localhost:8765/api/transferencia
```

Esse endpoint espera receber os seguintes parametros por POST

```bash
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```

## Sobre o projeto

A principal controller que faz todo o desafio funcionar está localizada em 
```
app/Controller/ApiController
```

Foram utilizados conceitos de injeção de dependencias, principios SOLID e clean code.
algumas sugestões de melhorias estão documentadas no próprio código fonte em formato TODO

O projeto é estraturado no conceito MVC (Model - View - Controller)

Um banco de dados relacional está sendo utilizado, o próprio framework oferece um ORM próprio, podendo ser utilizado o migrate para facilitar 

Não foram realizados scripts de testes, embora o framework ofereça optei por não desenvolver nesse primeiro momento pois como atualmente estou trabalhando em uma empresa, não queria prolongar o entregavél, embora eu tenha conhecimento sobre como são feitos e testados e Principalmente a importancia dos testes para sistemas complexos.


## Melhorias
1. Se enviar as notificações (SMS/Email) não for um requisito obrigatório para concluir uma transferência, então seria interesante
enviar a solicitação para uma fila de processamento. SQS da aws por exemplo. Assim, ao concluir uma transferência, o usuário não precisa esperar o retorno do endpoint (que pode ser instavel e abordar toda a operação) assim diminuimos o número de transferencias que apresentariam falhas por causa de um serviço instavel.



