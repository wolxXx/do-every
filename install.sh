#!/bin/bash

set -e

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

rm -rf public/vendor
mkdir -p "public/vendor/fontawesome"
mkdir -p "public/vendor/moment"
cp -vR vendor/fortawesome/font-awesome/css public/vendor/fontawesome/css
cp -vR vendor/fortawesome/font-awesome/js public/vendor/fontawesome/js
cp -vR vendor/fortawesome/font-awesome/webfonts public/vendor/fontawesome/webfonts

cp -vR vendor/moment/moment/dist/locale/de.js public/vendor/moment/locale_de.js
cp -vR vendor/moment/moment/dist/locale/en-gb.js public/vendor/moment/locale_en-gb.js
cp -vR vendor/moment/moment/min/locales.js public/vendor/moment/locales.js
cp -vR vendor/moment/moment/moment.js public/vendor/moment/moment.js

exit 0;