# vm.pl book-manager PoC
## Help
```shell script
make help
```

## Run
```shell script
make start (for the first time it )
make stop
```

## Tests
```shell script
make tests
```

## ENV
- please create `.env` and `.env.test` based on
`.env.example`

## API
1.Add book
```shell script
curl -H "Content-Type: application/json" -X POST -d '{"name":"adventure","category":"non-fiction"}' http://localhost:8000/api/books/
```
2.Update book
```shell script
curl -H "Content-Type: application/json" -X PUT -d '{"category":"adventure_novel"}' http://localhost:8000/api/books/1/
```

3.Get book
```shell script
curl -H "Content-Type: application/json" -X GET http://localhost:8000/api/books/1/
```

4.Get books
```shell script
curl -H "Content-Type: application/json" -X GET http://localhost:8000/api/books/
```
5.Delete book
```shell script
curl -H "Content-Type: application/json" -X DELETE http://localhost:8000/api/books/1/
```

## GUI
1. Simple book list: `http://localhost:8000/`

## Known issues
- problem with penetrating DB for app & tests
