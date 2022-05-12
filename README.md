# API Commerce

You can find Postman Collection below
## Postman collection
```https://www.getpostman.com/collections/ac8e970bbc30d3b11d8c```

## Steps to Run with Docker
- clone the repo 
    ```git clone git@github.com:AbdelrhamanAmin/api-commerce.git ```
- Switch to the repo directory 
    ```cd api-commerce```
- Copy the example env file and make the required configuration changes in the .env file
    ```cp .env.exmple .env```
- run
    ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```
    
- Start the app
    ```./vendor/bin/sail up -d```
    ```./vendor/bin/sail artisan key:generate```
- Run migrations 
    ```./vendor/bin/sail artisan migrate ```

## Features
- Implement Authentication using sanctum.
- User with role seller can create store.
- User with role seller can add products to his store.
- User with role buyer can add products to his cart from different stores.
- User can view his cart with items and its totals with VAT, shipping cost and subtotal.

## Database
- Implemented Schema approach could be changed with multi-tenant approach
    each seller could have a subdomain as a tenet for phase two or future work.
     






