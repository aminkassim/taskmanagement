Version 
1. php 8.1
2. laravel 10
3. laragon 6.0

How to Run Project

1. npm install
2. php artisan migrate
3. php artisan db:seed --class=DatabaseSeeder
4. php artisan serve (backend)
5. npm run dev (frontend)

login default:

email: admin@exam.com, password: 12345678


Bonus: Briefly explain how you would add authentication to protect these endpoints?

<b>For authentication API, im using Laravel sanctum</b>
1.	Use auth:sanctum middleware to protect routes, at file api.php
2.	Generate token using $user->createToken when using Api login, at file AuthController.php
3.	After generate, token will store in localStorage
4.	Get token from localstorage and insert to Authorization: Bearer header in axios






