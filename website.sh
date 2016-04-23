#!/bin/sh
echo 1.更新网页
echo 2.上传网页
echo Please choose:
read  M

yes|cp -fr /etc/nginx/nginx.conf /var/www/simonsmh.tk/nginx.conf
echo 已覆盖备份nginx.conf
cd /var/wwwfiles
chmod -R 777 *
chown -R root:root *
cd /var/www
chmod -R 777 *
chown -R root:root *
echo 已给予www目录完整最高权限

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
echo 已尝试重启nignx
cd /var/www
chmod -R 777 *
chown -R root:root *
echo 已给予www目录完整最高权限
echo 正在退出
exit 0