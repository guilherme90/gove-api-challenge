# Gove API

- PHP >= 8
- Laravel
- Postgres

## Setup

Execute os comandos abaixo para preparar o ambiente de desenvolvimento:

```shell
$ composer install
$ cp .env.example .env
```

Após criar o arquivo `.env` será necessário configurar variáveis de ambiente.

### Migrações
Rode as migrações para criar tabelas em seu banco de dados:

```shell
$ php artisan migrate
```

### Subindo o servidor
Após configurar o ambiente, basta subir o servidor.

```shell
$ php artisan serve
```

### Gerando arquivo CSV
Para facilitar os testes, foi feito um seed que gera nome e e-amils fictícios. O arquivo é salvo em
`/storage/app/schedules/batch.csv`

Para gerar este arquivo, execute o comando abaixo:
```shell
$ php artisan db:seed
```

### Executando workers

Para executar o processamento do arquivo CSV, é necessário que o job esteja rodando em background.
Em ambiente de produção é recomendado o supervisor.

```shell
$ php artisan queue:listen --queue=emails --tries=3 --backoff=5
```

Após realizar a leitura do CSV, temos que processar outro worker. Este worker é responsável por buscar os
registros e disparar a notificação.

```shell
$ php artisan schedule:work
```
