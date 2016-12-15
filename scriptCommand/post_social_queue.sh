#!/bin/bash
php /var/www/html/kacana.com/ artisan queue:work --daemon --sleep=3 --tries=3