# Install manual

- clone repo from git to server
- run `composer install`, to import dependencies
- create `.env` file with database and smtp data from `.env.example` 
- run `npm run dev`, to compile scss and js (optional)
- run `php artisan migrate` to create DB structure
- run `php artisan seed` to create default values to db
- login as admin: `risnyo96@gmail.com` / `asdasd`

With these steps you created the default values but you dont imported the questions from the old site.

### Import questions

- login to the old site: `risnyo96@gmail.com` / `risnyo96`
- list all questions without interactive questions
- copy the `SESSIONID` from cookies to `cookie.txt` on server (replace the old one)
- run `php artisan import:questions`
- if the command dont work fix the problem with the rights of wrinting files to the serve
- wait to finish

---

Login and control if everything works fine. If is necessary then fix the problems with the rights of wirting to the server. 

![logo](public/img/logo-web.png) enjoy the app  


