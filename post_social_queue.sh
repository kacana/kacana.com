#!/bin/bash
php artisan queue:work --daemon --sleep=3 --tries=3