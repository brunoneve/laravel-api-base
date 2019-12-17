
## Base for application Laravel API + Docker + ACL (Spatie Permission) + JWT Token

1 - cp .env.example to .env
2 - install docker and docker-compose
3 - choose change  or no | settings in docker-compose.yml
4 - docker-compose up
5 - docker-compose run api bash and run comand
    - composer install
    - php artisan key:generate
    - php artisan jwt:secret
    - php artisan migrator --seed
    
    

Ready, API running, good use! = D
