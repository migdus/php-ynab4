FROM php:7.4-cli

RUN apt-get update \
  && apt-get install -y \
   git-core \
   unzip \
   zip \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  # Locking to v.1.9.3 to to avoid error when Composer reach v.2.0
  && php composer-setup.php --install-dir=bin --filename=composer --version=1.9.3\
  && php -r "unlink('composer-setup.php');"

ADD . .
RUN composer install

ENTRYPOINT ["php"]