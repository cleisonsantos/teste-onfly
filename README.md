# Teste Onfly

Aplicação laravel de avaliação da empresa Onfly

### Execute os comandos baixo para preparar e executar o projeto:
``` 
composer install
```
- renomear o arquivo .env.example para .env e configurar o banco de dados dentro do mesmo e também definir FILESYSTEM_DRIVER=public no final do arquivo.

``` 
php artisan storage:link
```

``` 
php artisan key:generate
```

- criar as tabelas com as migrations:
``` 
php artisan migrate
```

- instale as dependencias node do projeto:
``` 
npm install && npm run dev
```
O framework utilizado no front-end foi o Vuejs!
