# jodit-connector-application

Default application for project [Jodit Application](https://github.com/xdan/jodit-connectors)

* [Read more about Jodit](https://xdsoft.net/jodit/)
* [Chagelog](./CHANGELOG.md)


### Run tests
Install full requires including dev

```bash
composer install
```

Start PHP server
```bash
npm start
```
or
```bash
cd ./docker && docker-compose up
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
