#!/bin/bash
while true; do php artisan db:backup --keep-only-s3 --upload-s3 kacanabucket; sleep 1m; done