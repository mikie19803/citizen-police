cd C:\xampp7\htdocs\projects\citizenPolice

php artisan queue:work --daemon --timeout=60 --tries=3


