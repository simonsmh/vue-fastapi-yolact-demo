#!/bin/sh
cp -f /etc/nginx/nginx.conf /var/www/simonsmh.tk/nginx.conf
echo 已覆盖备份nginx.conf
cd /var/wwwfiles
chmod -R 777 *
chown -R root *
cd /var/www
chmod -R 777 *
chown -R www-data *
echo 已给予www目录完整最高权限
echo 1.更新网页
echo 2.上传网页
echo 3.证书更新
case $* in
1)
echo 更新
cd /var/www
rm -rf /var/www/simonsmh.tk
git clone https://github.com/simonsmh/simonsmh.tk.git
;;
2)
echo 上传
cd /var/www/simonsmh.tk/
git config --global push.default simple
git config --global user.name "simonsmh"
git config --global user.email simonsmh@gmail.com
git config credential.helper store
git add .
git commit -m 'update'
git push
;;
3)
echo 证书
service nginx stop && certbot certonly --standalone --email simonsmh@gmail.com -d simonsmh.tk -d blog.simonsmh.tk -d tieba.simonsmh.tk -d openwrt.simonsmh.tk -d bt.simonsmh.tk -d pan.simonsmh.tk -d ipv6.simonsmh.tk -d ports.simonsmh.tk -d wiki.simonsmh.tk -d zh.wiki.simonsmh.tk -d zh.m.wiki.simonsmh.tk -d en.wiki.simonsmh.tk -d en.m.wiki.simonsmh.tk -d ja.wiki.simonsmh.tk -d ja.m.wiki.simonsmh.tk
;;
*)
echo 不选
;;
esac
service nginx restart
echo 已尝试重启nignx
cd /var/www
chmod -R 777 *
chown -R www-data *
echo 已给予www目录完整最高权限
echo 正在退出
exit 0