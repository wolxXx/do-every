#!/bin/bash

set -e

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

rm -rf public/vendor
mkdir -p "public/vendor/fontawesome"
cp -vR vendor/fortawesome/font-awesome/css public/vendor/fontawesome/css
cp -vR vendor/fortawesome/font-awesome/js public/vendor/fontawesome/js
cp -vR vendor/fortawesome/font-awesome/webfonts public/vendor/fontawesome/webfonts
exit 0;