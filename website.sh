#!/bin/sh
echo 1.更新网页
echo 2.删除链接
echo 3.上传网页
echo Please choose:
read  M
echo
if [ "$M" = "1" ]
then
echo 选项1
cd /var/www
rm -rf /var/www/simonsmh.tk
git clone https://github.com/simonsmh/simonsmh.tk.git
cp -Rf /var/wwwfiles/links/. /var/www/simonsmh.tk
elif [ "$M" = "2" ]
then
echo 选项2
cd /var/www/simonsmh.tk
rm -rf /var/www/simonsmh.tk/CAKEY
rm -rf /var/www/simonsmh.tk/files
rm -rf /var/www/simonsmh.tk/sfiles
elif [ "$M" = "3" ]
then
echo 选项3
cd /var/www/simonsmh.tk
rm -rf /var/www/simonsmh.tk/CAKEY
rm -rf /var/www/simonsmh.tk/files
rm -rf /var/www/simonsmh.tk/sfiles
git config credential.helper store
git add .
git commit -m 'update'
git push
else
echo 正在退出
fi
exit 0
