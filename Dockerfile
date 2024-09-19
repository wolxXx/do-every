ARG ubuntuVersion="24.04"

FROM ubuntu:$ubuntuVersion

ARG nodeVersion="22"
ARG phpVersion="8.3"

RUN apt update && apt install tzdata -y
ENV TZ="Europe/Berlin"

RUN apt update && apt install -y software-properties-common htop btop curl wget git cron wget curl git vim net-tools bash-completion inetutils-ping unzip


RUN curl -fsSL https://fnm.vercel.app/install | bash -s -- --install-dir './fnm' \
&& cp ./fnm/fnm /usr/bin && fnm install $nodeVersion

RUN ln -s /root/.local/share/fnm/node-versions/*/installation/bin/* /usr/local/bin/.

RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/apache2

RUN apt update
RUN apt dist-upgrade -y

RUN apt install -y \
    apache2 apache2-dev apache2-utils apachetop mysql-client mycli \
    php$phpVersion libapache2-mod-php$phpVersion php$phpVersion-common php$phpVersion-mysql php$phpVersion-gmp php$phpVersion-ldap php$phpVersion-curl \
    php$phpVersion-xml php$phpVersion-cli php$phpVersion-intl \
    php$phpVersion-mbstring php$phpVersion-xmlrpc php$phpVersion-gd php$phpVersion-bcmath \
    php$phpVersion-zip  php$phpVersion php$phpVersion-bcmath php$phpVersion-cli php$phpVersion-curl php$phpVersion-dev php$phpVersion-gd \
    php$phpVersion-imap php$phpVersion-intl php$phpVersion-mbstring php$phpVersion-mysql php$phpVersion-opcache php$phpVersion-readline \
    php$phpVersion-soap php$phpVersion-tidy php$phpVersion-xml php$phpVersion-xsl php$phpVersion-zip php$phpVersion-xdebug php$phpVersion-xdebug php$phpVersion-imagick

RUN a2enmod headers
RUN a2enmod rewrite

RUN wget https://raw.githubusercontent.com/wolxXx/toolz/main/fixPHP.sh && chmod +x fixPHP.sh && ./fixPHP.sh

RUN sed -i '/opcache.enable=/c\opcache.enable = 1' "/etc/php/$phpVersion/apache2/php.ini"


WORKDIR /var/www

CMD ["apachectl", "-D", "FOREGROUND"]