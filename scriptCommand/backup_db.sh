#!/bin/bash
while true; do php artisan db:backup --upload-s3 kacanabucket; sleep 5m; done