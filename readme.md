## install manual

- get composer 
- clone repo to local
- make localhost and a database 
- in .env edit DB and smtp login data 
- run: php artisan migrate:refresh --seed
- run: php artisan serve
- visit localhost in browser 

## manual for developing

- get composer, node, npm
- clone repo to local 
- make localhost and db
- edit .env -> db and smtp login 
- run: npm install 
- run: php artisan migrate:refresh --seed
- run: npm run watch
- run: php artisan serve
- edit files then commit 

### enjoy :)