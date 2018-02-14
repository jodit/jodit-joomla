# jodit-connector-application

Default application for project [Jodit Application](https://github.com/xdan/jodit-connectors)

[Read more about Jodit](https://xdsoft.net/jodit/)


### Run tests
Install full requires including dev

```bash
composer install
```

Start PHP server
```bash
php -S localhost:8181 -t ./
```
Run tests
```bash
./vendor/bin/codecept run
```

Run only API tests
```bash
./vendor/bin/codecept run api
```

Run only unit tests
```bash
./vendor/bin/codecept run unit
```
