// laravel ignore php platform 
composer --ignore-platform-req=php update

composer install --optimize-autoloader --no-dev

// .htaccess
RewriteCond %{HTTP_HOST} ^www\domain\.com
RewriteRule ^(.*)$ https://domain.com$1 [R=301,L]


