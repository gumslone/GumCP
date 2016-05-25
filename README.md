# GumCP
Web Control Panel for Raspberry Pi

to install web server on your raspberry pi do this:
```
sudo apt-get update && sudo apt-get install apache2 php5 php5-ssh2
```
install git:
```
sudo apt-get update && sudo apt-get install git
```
make sure that php5-ssh2 is installed:
```
sudo apt-get install php5-ssh2
```
restart apache:
```
sudo service apache2 restart
```
Install GumCP:
```
cd /var/www/html

sudo git clone https://github.com/gumslone/GumCP.git
```
make your changes to your `/include/config.php` file.

open GumCP in your browser:

`http://RasPi-IP/GumCP/index.php`

