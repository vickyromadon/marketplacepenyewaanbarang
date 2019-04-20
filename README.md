Kebutuhan :

1. Versi PHP harus 7.1 ++
2. Server Local, seperti : XAMPP, NGINX, dll
3. Install Composer

Hal yang di lakukan setelah clone project :

1. Install Dependencies
	- composer update (di cmd)
	- composer install (di cmd)
	- npm install (di cmd)
	- npm run dev (di cmd)

2. Resolve Environment
	- create .env file (copy from .env.example)
	- create new table on database
	- solve database connection di file .env
		* change only : DB_DATABASE, DB_USERNAME, and DB_PASSWORD (sesuaikan dengan database kalian)
	- php artisan key:generate (di cmd)

3. Tymon JWT-Auth Package
	- php artisan jwt:secret (di cmd)

4. Migrate Database
	- php artisan migrate:refresh --seed (di cmd)

5. Finishing
	- composer dump-autoload (di cmd)
	
NB :

1. Jangan ada dulu melakukan perintah "git push" ya.

2. Setiap kali melakukan git pull lakukan kembali tahapan no 1 (install dependencies) dan php artisan migrate:fresh (di cmd) dan php artisan db:seed (di cmd)