#!/bin/bash
while true; do php artisan db:backup --keep-only-s3 --upload-s3 kacanabucket; sleep 5m; done