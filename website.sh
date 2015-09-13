#!/bin/sh
echo 1.更新网页
echo 2.删除链接
echo 3.上传网页
echo 4.加入链接
echo Please choose:
read  M
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
rm -rf /var/www/simonsmh.tk/CAKEY
rm -rf /var/www/simonsmh.tk/files
rm -rf /var/www/simonsmh.tk/sfiles
elif [ "$M" = "3" ]
then
echo 选项3
rm -rf /var/www/simonsmh.tk/CAKEY
rm -rf /var/www/simonsmh.tk/files
rm -rf /var/www/simonsmh.tk/sfiles
cd /var/www/simonsmh.tk/
git config credential.helper store
git add .
git commit -m 'update'
git push
cp -Rf /var/wwwfiles/links/. /var/www/simonsmh.tk
elif [ "$M" = "4" ]
then
echo 选项4
cp -Rf /var/wwwfiles/links/. /var/www/simonsmh.tk
else
echo 不选
fi
echo 正在退出
exit 0
