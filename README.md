# GumCP
Web Control Panel for Raspberry Pi

![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/dashboard.png)

** Features **
- system details, like cpu load, disk and memory usage, cpu temperature etc.
- start/stop services
- kill processes
- change mode and value of the GPIO pins
- system reboot
- system update
Check the screenshots folder.

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
Get the wiringPi project using this commands:
```
cd
```
```
git clone git://git.drogon.net/wiringPi
```
```
cd wiringPi
```
```
git pull origin
```
```
./build
```
Install GumCP:
```
cd /var/www/html

sudo git clone https://github.com/gumslone/GumCP.git
```
make your changes to your `/include/config.php` file.

open GumCP in your browser:

`http://RasPi-IP/GumCP/index.php`


[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N)
