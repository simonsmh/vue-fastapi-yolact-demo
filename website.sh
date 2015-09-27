#!/bin/sh
echo 1.更新网页
echo 2.上传网页
echo Please choose:
read  M

if [ "$M" = "1" ]
then
echo 选项1
cd /var/www
rm -rf /var/www/simonsmh.tk
git clone https://github.com/simonsmh/simonsmh.tk.git

elif [ "$M" = "2" ]
then
echo 选项2
cd /var/www/simonsmh.tk/
git config --global user.name "simonsmh"
git config --global user.email simonsmh@gmail.com
git config credential.helper store
git add .
git commit -m 'update'
git push

else
echo 不选
fi
service nginx restart
echo 正在退出
exit 0
