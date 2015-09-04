#!/bin/bash
cd /var/www
rm -rf /var/www/simonsmh.tk
git clone https://github.com/simonsmh/simonsmh.tk.git
cp -Rf /var/wwwfiles/links/. /www/simonsmh.tk
exit 0