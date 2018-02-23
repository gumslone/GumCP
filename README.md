# GumCP
Web Control Panel for Raspberry Pi

Original repository: https://github.com/gumslone/GumCP

![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/dashboard.png)

Find more screenshots in the ![screenshots folder](https://github.com/gumslone/GumCP/blob/master/screenshots/).

Video:

[![Web Control Panel for Raspberry Pi](https://github.com/gumslone/GumCP/blob/master/screenshots/video.png)](https://youtu.be/rCi9OGLOstU)



**Features**
- system details, like cpu load, disk and memory usage, cpu temperature etc.
- start/stop services
- kill processes
- change mode and value of the GPIO pins
- system reboot
- system update
- execute command (for advanced users only) requires php-ssh2
- create custom buttons to execute custom commands (i.e. set GPIO pin to HIGH/LOW, execute python script, execute bash script etc.) requires php-ssh2
- added third party modules like: File Manager and Database Manager which you can activate in the config.php file

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
**Install GumCP:**
```
cd /var/www/html

sudo git clone https://github.com/gumslone/GumCP.git
```
make your changes to your `/include/config.php` file.

open GumCP in your browser:

`http://RasPi-IP/GumCP/index.php`



To **upgrade GumCP** use this commands:

```cd /var/www/html/GumCP```

```sudo git pull origin```

after update make sure to edit the **include/config.php** file


**If your Raspberry Pi is accessible from internet**, you should tell the bots and spiders like googlebot not to crawl the pages of GumCP and exclude GumCP from search results with a robots.txt file.
Just create a file **robots.txt** place it in the webroot of your raspberry pi (usually its /var/www/html/) and define in the robots.txt the parts of web content whch shouldn't be crawled like this:

```User-agent: *
Disallow: /GumCP/
```
which disallows access to GumCP folder

or

```
User-agent: *
Disallow: /
```
to exclude the entire web root from being crawled by bots

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N)
