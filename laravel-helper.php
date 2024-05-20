// laravel ignore php platform 
composer --ignore-platform-req=php update

composer install --optimize-autoloader --no-dev

// .htaccess
RewriteCond %{HTTP_HOST} ^www\domain\.com
RewriteRule ^(.*)$ https://domain.com$1 [R=301,L]



// root command send email servicemanager
[program:linksposting-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/linksposting/public_html/artisan queue:work --queue=default --sleep=3 --tries=3
autostart=true
autorestart=true
user=linksposting
numprocs=8
redirect_stderr=true
stdout_logfile=/home/linksposting/public_html/storage/logs/worker.log


