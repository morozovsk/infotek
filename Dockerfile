FROM yiisoftware/yii2-php:8.4-fpm

# Install sockets extension
RUN docker-php-ext-install sockets
