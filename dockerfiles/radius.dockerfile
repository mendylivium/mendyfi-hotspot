# Use the official PHP image
FROM php:8.3.7-cli

# Copy your application code to the container
# COPY . /usr/src/myapp
RUN apt-get update && apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install sockets curl
# Set the working directory
WORKDIR /var/www

# Run server.php when the container starts
CMD ["php", "server.php"]
