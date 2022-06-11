
# Laravel Actions - Gebitech

![GitHub repo size](https://img.shields.io/github/repo-size/pontes-guilherme/actions-laravel-gebitech?style=for-the-badge)
![GitHub language count](https://img.shields.io/github/languages/count/pontes-guilherme/actions-laravel-gebitech?style=for-the-badge)

> Este projeto é parte de uma apresentação para a Gebitech - iniciativa que tem como finalidade abordar novas tecnologias/conceitos/padrões para desenvolvimento pessoal e profissional, desenvolvido pela empresa [Gebit](https://www.gebit.com.br/). Nesse repositório, mostro de maneira prática a refatoração de um fluxo simples de cadastro de clientes utilizando o padrão Actions.

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:

* **Node/npm** - Para execução do Front-end do projeto
<!-- * **Composer** - Para instalação inicial de pacotes -->
* **Docker/docker-compose** - Para execução dos serviços que o projeto utilizará, sem a necessidade de um setup extenso na máquina local

## 🚀 Instalando Laravel Actions

Para instalar, siga estas etapas:

Linux:

* Clone o projeto 

* Navegue até o diretório do projeto clonado
``
cd actions-laravel-gebitech
``

<!-- * Instale os pacotes via composer
``
composer install
`` -->

* Crie um arquivo .env copiando o conteúdo do arquivo .env.example. Se desejar, altere as variáveis do projeto de acordo com sua necessidade
``
cp .env.example .env
``

* Utilize o Laravel Sail para execução dos containeres de serviços do projeto
``
./vendor/bin/sail up -d
``

* Instale as dependências do Front-end utilizando npm
``
npm install
``

* Gere os arquivos estáticos para que seja possível acessar as views mais atualizadas
``
npm run dev
``

* Acesse o container docker que está executando o Laravel e instale suas dependências
``
./vendor/bin/sail composer install
``

* Se desejar, gere uma nova chave para sua aplicação
``
./vendor/bin/sail artisan key:generate
``

**Tip**: Se a utilização do *Laravel Sail* se tornar frequente, pode ser mais conveniente criar um *alias* para o comando.
Para tal, coloque a linha abaixo no seu arquivo de inicialização de ambiente de preferência (*e.g.* .bashrc, .bash-profile, .zshrc, .profile)
```
alias  sail='[ -f sail ] && bash sail || bash vendor/bin/sail
```

Em seguida, para que o *alias* fique disponivel para uso, execute o comando `source` no arquivo de ambiente escolhido
*e.g.* `source .zshrc`

Dessa forma, será possível utilizar o comando `sail` diretamente: `sail artisan migrate`, `sail composer install`

## ☕ Usando Laravel Actions

Por padrão, os serviços rodarão nas seguintes portas:

* Site: `localhost:80`
* Banco MySQL: `localhost:3306`
* MailHog Dashboard: `localhost:8025` 

## 📁 Organização geral do projeto e arquivos de interesse

### Branches
O projeto foi dividido em 4 branches

Em cada uma delas, a ideia de fluxo é semelhante. É possível cadastrar um cliente por meio da interface Web, e por linha de comando utilizando *artisan*.

> Arquivos de interesse comuns:
> routes/auth.php
> resources/views/custom-auth/register.blade.php
> resources/views/mail/welcome.blade.php
> app/Mail/WelcomeMail.php

#### main
Essa branch contém código em estado inicial. Representa um código com regras de negócio repetidas em classes diferentes

> Arquivos de interesse:
> app/Http/Controllers/CustomAuth/RegisterController.php
> app/Console/Commands/RegisterUserCommand.php

#### refactoring_with_actions
Tem como origem a branch **main**.
Essa branch contém o código refatorado para a utilização de Actions. Nesta branch, as Actions foram criadas manualmente

> Arquivos de interesse:
> app/Http/Controllers/CustomAuth/RegisterController.php
> app/Console/Commands/RegisterUserCommand.php
> app/Actions/*

#### actions_and_contracts
Tem como origem a branch **refactoring_with_actions**.
Essa branch contém o código refatorado para a utilização de Actions . Nesta branch, as Actions foram criadas manualmente. Além disso, foram utilizadas as ideias de **Injeção de Dependências** e **desacoplamento** para separar a implementação de Actions de sua utilização. Para isso, adicionamos um diretório para contratos.

> Arquivos de interesse:
> app/Actions/*
> app/Contracts/*
> app/Providers/[ActionsServiceProvider.php](https://github.com/pontes-guilherme/actions-laravel-gebitech/blob/actions_and_contracts/app/Providers/ActionsServiceProvider.php "ActionsServiceProvider.php")
> config/[app.php](https://github.com/pontes-guilherme/actions-laravel-gebitech/blob/actions_and_contracts/config/app.php "app.php")

Note que para que a interface ou contrato (parte abstrata) seja relacionado à uma classe (parte concreta)
 1. A classe precisa implementar a interface em questão
 2. Deve-se relacionar a interface à classe no **Service Container** do Laravel. Isso é feito através de **Service Providers**. No caso da implementação neste projeto, ver [ActionsServiceProvider.php](https://github.com/pontes-guilherme/actions-laravel-gebitech/blob/actions_and_contracts/app/Providers/ActionsServiceProvider.php "ActionsServiceProvider.php")
 3. O Service Provider é então registrado no arquivo config/[app.php](https://github.com/pontes-guilherme/actions-laravel-gebitech/blob/actions_and_contracts/config/app.php "app.php"). Ver array "providers" no arquivo.

#### actions_lib
Tem como origem a branch **refactoring_with_actions**.
Nessa branch, utilizamos [um pacote para criação de Actions](https://laravelactions.com/) que nos permite usar outras funcionalidades e extender o uso de Actions em contextos diferentes do projeto. 
Para demostrar brevemente a utilização do pacote, reescrevemos a Action **RegisterUser**.

> Arquivos de interesse
> app/Actions/Auth/[RegisterUser.php](https://github.com/pontes-guilherme/actions-laravel-gebitech/blob/actions_lib/app/Actions/Auth/RegisterUser.php "RegisterUser.php")
>  routes/auth.php
>  app/Console/Commands/Kernel.php

Note que, nesse exemplo, não apenas reaproveitamos a Action **RegisterUser** para utilização como comando e controller, como também removemos os arquivos de **Controller** e **Command** do projeto. Para tal, referenciamos a classe da Action (**RegisterUser.php**) diretamente no arquivo de rotas (para utilização como **Controller**), e no arquivo **Kernel.php** (para utilização como **Command**).


### Sobre a refatoração
Vale ressaltar que as refatorações feitas neste projeto possuem fim demonstrativo. Algumas escolhas foram feitas de maneira arbitrária e certamente iriam variar de acordo com o contexto e tipo de projeto. Para citar um exemplo, a funcionalidade de envio de e-mail para onboarding de clientes poderia ser implementada de maneira alternativa utilizando eventos: 

> Ao criar um cliente, um evento seria disparado; um *Listener* capturaria este evento e então faria o envio de e-mail automaticamente.

Cabe ao time e aos desenvolvedores do projeto decidir o que se tornará uma Action, como compor Actions mais complexas utilizando Actions simples, ou mesmo se a utilização de Actions seria a forma mais recomendada de se implementar regras de negócio dado o escopo do projeto.

##  ✏️ Modificando o projeto
Se desejar fazer alterações no projeto locamente, sobretudo no caso de alterações em views, arquivos css e js, é necessário estar rodando o **Laravel Mix** para que sejam gerados os arquivos estáticos.
Para tal, é possível usar a opção *watch*. Isso permitirá que o **Mix** identifique alterações nos arquivos de interesse e gera os arquivos estáticos automaticamente.

```
npm run watch
```

## 📚 Referências

* Biblioteca utilizada no projeto: [Laravel Actions](https://laravelactions.com/)
* Outra biblioteca para Actions. Implementação mais simplificada: [Queueable Actions in Laravel](https://github.com/spatie/laravel-queueable-action)
* [Organize Laravel Applications With Actions](https://laravel-news.com/organize-laravel-applications-with-actions)
* [Restructuring a Laravel Controller using Services, Events, Jobs, Actions, and more](https://laravel-news.com/controller-refactor)
* [Refactoring to Actions](https://freek.dev/1371-refactoring-to-actions)
* Repositórios que utilizam Actions:
	* [Laravel Jetstream](https://github.com/laravel/jetstream)
	* [Laravel Envy](https://github.com/worksome/envy)
