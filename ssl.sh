#!/bin/bash
/usr/bin/php /var/www/ssl_cron/get_random_domain.php>/var/www/ssl_cron/domain.txt
domain=$(</var/www/ssl_cron/domain.txt)
echo "$domain"
if [ "$domain" = "NO" ]; then
   echo "There are NO domains without SSL! Yaaa-hooo!";
   exit;
fi
/usr/bin/curl keitaro.io/enable-ssl.sh > /var/www/ssl_cron/run.sh; 
/usr/bin/bash /var/www/ssl_cron/run.sh -D $domain | sed 's/\x1B\[[0-9;]\+[A-Za-z]//g' | tee /var/www/ssl_cron/result.txt
/usr/bin/php /var/www/ssl_cron/set_keitaro_ssl.php;