1.下载工具
vagrant 2.0.0  https://www.vagrantup.com/
virtualbox 5.1.28 https://www.virtualbox.org/wiki/Downloads
xshell5 http://www.netsarang.com/download/down_xsh.html

2.下载vagrantbox
ubuntu http://www.vagrantbox.es/
XXXX.box


3.安装以下三个软件
vagrant 2.0.0 
virtualbox 5.1.28
xshell5


4.打开xshell5 输入指令
1.添加指令
vagrant box add ubuntu1404 ubuntu1404.box

2.切换到一个新的文件夹输入初始化指令
vagrant init ubuntu1404
3.连接到box内部（默认用户名:vagrant 密码:vagrant
vagrant ssh

对虚拟机优化
替换源
sudo cp /etc/apt/sources.list /etc/apt/sources.list.bak #备份
sudo vim /etc/apt/sources.list #修改源
将文件内容替换成源文件内容
deb http://mirrors.aliyun.com/ubuntu/ trusty main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-security main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-updates main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-backports main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-security main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-updates main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-backports main restricted universe multiverse

sudo apt-get update #更新列表

LA|NMP环境
nginx
sudo apt-get install nginx
nginx -v
sudo service nginx restart #重启nginx服务

Apache
sudo apt-get install apache2
apache2 -v
sudo service apache2 restart #重启apache服务
修改apache监听端口8888
cd /etc/apache2/
sudo vim ports.conf
Listen 8888
sudo service apache2 restart #重启apache服务
curl -I 'http://127.0.0.1:8888'

Mysql
sudo apt-get install mysql-server #服务器端
安装期间会提示输入为mysql设置root密码，我这边不操作，直接enter 不设置密码
sudo apt-get install mysql-client #客户端
mysql -uroot -p #测试连接库，上面安装服务端没有设置密码，这里直接enter进入

php
sudo apt-get install php5-cli
php -v

PHP扩展

sudo apt-get install php5-mcrypt
sudo apt-get install php5-mysql
sudo apt-get install php5-gd

支持apache2的php模块
sudo apt-get install libapache2-mod-php5 
sudo service apache2 restart #重启服务
开启rewrite功能
sudo a2enmod rewrite


支持nginx fastcgi
sudo apt-get install php5-cgi php5-fpm
sudo service ngnix restart #重启服务

ps -ef | grep apache #查看服务是否启动
sudo /etc/init.d/nginx start #启动服务
修改成9000端口 ，默认sock模式
cd /etc/php5/fpm/pool.d
sudo vim www.conf # search listen = 127.0.0.1:9000
sudo /etc/init.d/php5-fpm restart

Vagrant高级配置
 config.vm.network "forwarded_port", guest: 80, host: 8888 
 config.vm.network "forwarded_port", guest: 8888, host: 8889
 config.vm.hostname="ubuntu1404" #主机名
网络设置
config.vm.network "private_network", ip: "192.168.199.101"  #打包的时候最好把全部网络配置关闭 防止出错
#config.vm.network "private_network", ip: "192.168.199.122",auto_config: true  #打包好box的错误时候的设置

共享目录
config.vm.synced_folder "/Users/vincent/code/", "/home/www"

vagrant init        初始化vagrantfile
vagrant add box     添加box，自动帮你生成vagrantfile
vagrant halt        关闭虚拟机
vagrant destroy     销毁虚拟机
vagrant ssh         连接虚拟机
vagrant reload      重新加载vagarntfile文件
vagrant suspend     暂时挂起虚拟机
vagrant status      查看虚拟机运行状态

打包分发box
vagrant halt
vagrant package --output xxx.box
vagrant package --output xxx.box --base virtual_name

box升级咋办？
1.更新vagrantfile
config.vm.provision 'shell', inlin:<<-SHELL
apt-get install y redis-server
SHELL
end

vagrant reload --provision

2.重新打包分发

GUI调试
vagrantfile  vagrant line 52

