FROM ubuntu:24.04

RUN apt update && apt install tzdata -y
ENV TZ="Europe/Berlin"

RUN apt update && apt install -y software-properties-common htop btop curl wget git cron

ARG version=22
RUN apt update -y && apt install curl unzip -y \
&& curl -fsSL https://fnm.vercel.app/install | bash -s -- --install-dir './fnm' \
&& cp ./fnm/fnm /usr/bin && fnm install $version

RUN ln -s /root/.local/share/fnm/node-versions/*/installation/bin/* /usr/local/bin/.

RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/apache2

RUN apt update
RUN apt dist-upgrade -y


RUN apt install -y php8.3 libapache2-mod-php8.3 php8.3-common php8.3-mysql php8.3-gmp php8.3-ldap php8.3-curl \
    wget curl git vim net-tools bash-completion inetutils-ping \
    apache2 apache2-dev apache2-utils apachetop mysql-client mycli \
    php8.3-xml php8.3-cli php8.3-intl \
    php8.3-mbstring php8.3-xmlrpc php8.3-gd php8.3-bcmath \
    php8.3-zip  php8.3 php8.3-bcmath php8.3-cli php8.3-curl php8.3-dev php8.3-gd php8.3-imap php8.3-intl php8.3-mbstring php8.3-mysql php8.3-opcache php8.3-readline php8.3-soap php8.3-tidy php8.3-xml php8.3-xsl php8.3-zip php-xdebug php-imagick unzip

RUN a2enmod headers
RUN a2enmod rewrite

RUN wget https://raw.githubusercontent.com/wolxXx/toolz/main/fixPHP.sh && chmod +x fixPHP.sh && ./fixPHP.sh

WORKDIR /var/www

CMD ["apachectl", "-D", "FOREGROUND"]