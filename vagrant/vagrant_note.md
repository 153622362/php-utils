1.���ع���
vagrant 2.0.0  https://www.vagrantup.com/
virtualbox 5.1.28 https://www.virtualbox.org/wiki/Downloads
xshell5 http://www.netsarang.com/download/down_xsh.html

2.����vagrantbox
ubuntu http://www.vagrantbox.es/
XXXX.box


3.��װ�����������
vagrant 2.0.0 
virtualbox 5.1.28
xshell5


4.��xshell5 ����ָ��
1.���ָ��
vagrant box add ubuntu1404 ubuntu1404.box

2.�л���һ���µ��ļ��������ʼ��ָ��
vagrant init ubuntu1404
3.���ӵ�box�ڲ���Ĭ���û���:vagrant ����:vagrant
vagrant ssh

��������Ż�
�滻Դ
sudo cp /etc/apt/sources.list /etc/apt/sources.list.bak #����
sudo vim /etc/apt/sources.list #�޸�Դ
���ļ������滻��Դ�ļ�����
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

sudo apt-get update #�����б�

LA|NMP����
nginx
sudo apt-get install nginx
nginx -v
sudo service nginx restart #����nginx����

Apache
sudo apt-get install apache2
apache2 -v
sudo service apache2 restart #����apache����
�޸�apache�����˿�8888
cd /etc/apache2/
sudo vim ports.conf
Listen 8888
sudo service apache2 restart #����apache����
curl -I 'http://127.0.0.1:8888'

Mysql
sudo apt-get install mysql-server #��������
��װ�ڼ����ʾ����Ϊmysql����root���룬����߲�������ֱ��enter ����������
sudo apt-get install mysql-client #�ͻ���
mysql -uroot -p #�������ӿ⣬���氲װ�����û���������룬����ֱ��enter����

php
sudo apt-get install php5-cli
php -v

PHP��չ

sudo apt-get install php5-mcrypt
sudo apt-get install php5-mysql
sudo apt-get install php5-gd

֧��apache2��phpģ��
sudo apt-get install libapache2-mod-php5 
sudo service apache2 restart #��������
����rewrite����
sudo a2enmod rewrite


֧��nginx fastcgi
sudo apt-get install php5-cgi php5-fpm
sudo service ngnix restart #��������

ps -ef | grep apache #�鿴�����Ƿ�����
sudo /etc/init.d/nginx start #��������
�޸ĳ�9000�˿� ��Ĭ��sockģʽ
cd /etc/php5/fpm/pool.d
sudo vim www.conf # search listen = 127.0.0.1:9000
sudo /etc/init.d/php5-fpm restart

Vagrant�߼�����
 config.vm.network "forwarded_port", guest: 80, host: 8888 
 config.vm.network "forwarded_port", guest: 8888, host: 8889
 config.vm.hostname="ubuntu1404" #������
��������
config.vm.network "private_network", ip: "192.168.199.101"  #�����ʱ����ð�ȫ���������ùر� ��ֹ����
#config.vm.network "private_network", ip: "192.168.199.122",auto_config: true  #�����box�Ĵ���ʱ�������

����Ŀ¼
config.vm.synced_folder "/Users/vincent/code/", "/home/www"

vagrant init        ��ʼ��vagrantfile
vagrant add box     ���box���Զ���������vagrantfile
vagrant halt        �ر������
vagrant destroy     ���������
vagrant ssh         ���������
vagrant reload      ���¼���vagarntfile�ļ�
vagrant suspend     ��ʱ���������
vagrant status      �鿴���������״̬

����ַ�box
vagrant halt
vagrant package --output xxx.box
vagrant package --output xxx.box --base virtual_name

box����զ�죿
1.����vagrantfile
config.vm.provision 'shell', inlin:<<-SHELL
apt-get install y redis-server
SHELL
end

vagrant reload --provision

2.���´���ַ�

GUI����
vagrantfile  vagrant line 52

