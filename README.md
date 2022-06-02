<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a>

# [laravel practice task - Kaushal]

This repo has below functionality !

----------------------------------------
- Create one simple admin panel. Where admin can add/update/delete product details like name, quantity, price, image, active.
- Now the user can add product into the cart after login (cart will be local, no need to save into DB)
- When users checkout all cart related details are added into database.
- Now the admin can see all the order details.
- Admin can see the top 10 selling products.
- Stripe integration (only for add user card, no need to payment)
- Add 100k products using seeders.
----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation#installation)


Clone the repository

    git clone git@github.com:junglikaushal/laravel-practice-task.git

Switch to the repo folder

    cd laravel-practice-task

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder (**Products Seeder have 100K products data so it takes long time to execute - You can change it from products seeder file **)

    php artisan db:seed

Run to create the symbolic link for storage public disk

    php artisan storage:link

Add stripe key in .env file
    
    STRIPE_KEY=pk_XXXXXXXXXXX
    STRIPE_SECRET=pk_XXXXXXXXXXX

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

Admin   : http://localhost:8000/admin

    Email : admin@email.com
    Password : 123456

User  : http://localhost:8000/user
    
    Create user from registration