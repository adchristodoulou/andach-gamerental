# Andach Game Rental
## Summary
This is a PHP application to run a website that will let you rent video games out. 

## Installation Instructions for Ubuntu 16.04.3 (x64)
### Install Apache, mySQL, PHP, etc.
1. Install the PHP7.1 and webmin repos
    1. `sudo add-apt-repository -y ppa:ondrej/php`
    1. `sudo echo "deb http://download.webmin.com/download/repository sarge contrib" >> /etc/apt/sources.list`
    1. `wget http://www.webmin.com/jcameron-key.asc`
    1. `sudo apt-key add jcameron-key.asc`
    1. `sudo apt-get update`
2. Install Apache, PHP and mySQL
    1. `sudo apt-get install -y apache2`
    2. `sudo apt-get install -y php7.1 zip unzip php7.1-curl php7.1-mbstring php7.1-dom php7.1-gd php7.1-mysql php7.1-zip composer webmin mariadb-server`
3. Secure the MariaDB installation
    1. `sudo /usr/bin/mysql_secure_installation`
    2. I strongly recommend you reset the MariaDB root password, disable root login remotely, remove anonymous users and the test DB, and reload priviliges. (i.e. yes to all answers)
6. Setup the apache folders. 
    1. `sudo nano /etc/apache2/apache2.conf`
    2. Find the section that says <Directory /var/www> and change "AllowOverride None" to "AllowOverride All"
    3. `sudo nano /etc/apache2/sites-available/000-default.conf`
    4. Find the line that says "DocumentRoot" and make sure it says "DocumentRoot /var/www/html/andach-gamerental/public"
    5. `sudo a2enmod rewrite`
    6. `sudo service apache2 restart`

### Setup the MariaDB database
1. `mysql -u root -p` (enter the password as needed)
6. `CREATE DATABASE gamerental;CREATE USER gamerental;GRANT ALL on gamerental.* to 'gamerental';SET PASSWORD for 'gamerental' = PASSWORD('XXXXXX');EXIT;`
7. You should now be back to the normal BASH shell. 

### Install Andach Game Rental
1. `cd /var/www/html`
2. `sudo rm index.html`
3. Change the owner of the html folder from root to www-data.
4. `sudo -u www-data git clone https://github.com/useaquestion/andach-gamerental`
5. Set up the .env file accordingly for the usernames and passwords on your system. 
6. At this point, check your server. It should be giving you an error 500. 

### Install from Composer
1. `cd /var/www/html/andach-gamerental`
1. `composer install`
6. `sudo service apache2 restart`
7. `php artisan migrate:refresh --seed`.
8. `php artisan storage:link`

## Securing your Server (Assumes you did install Webmin)
1. Regularly run updates to programs as needed. 
    1. `sudo apt-get update`
    1. `sudo apt-get upgrade`
1. Enable a firewall. 
    1. In the Networking->Linux Firewall module, select to drop everything except SSH and IDENT on eth0. 
    1. Add a rule to accept on TCP ports 80 and 443. 
    1. Then change the port 22 (SSH) rule so that the "source address" is your home/office IP address. Don't want SSH open to the world, do you? 
    1. Also add ports 3306 and 10000, again, only locked down to one IP address. 
    1. The default option for the INPUT chain should be to Drop. The default action for FORWARD and OUTPUT should be Allow, with no other rules in these chains.
    1. Once this is done, click "Apply Configuration". Ensure to select to establish the firewall is activated at boot time.  
2. Enable remote mySQL. In the Servers->mySQL Database Server module, click "mySQL Server Configuration", then change "MySQL server listening address" to "Any". Then save & restart the mySQL server. Ensure that you can't access the mySQL from any other IP. If you set your firewall rule up correctly, then you should be secure. 
3. `sudo service mysql restart`
2. Add a Let's Encrypt SSH certificate for Webmin - https://www.digitalocean.com/community/tutorials/how-to-install-webmin-on-ubuntu-16-04 (Step 2)
5. Install Zabix - https://www.zabbix.com/documentation/3.4/manual/installation/install_from_packages/debian_ubuntu
6. Install Afick - https://ubuntuforums.org/showthread.php?t=2235300

## Installing an SSL Certificate
1. Enable SSL for apache. 
2. `sudo a2enmod ssl`
3. `sudo a2ensite default-ssl.conf`
4. `sudo nano /etc/apache2/sites-available/default-ssl.conf` and change the DocumentRoot parameter accordingly. 
4. `sudo service apache2 restart`
5. Clone Let's Encrypt information into your /usr/local directory `cd /usr/local
sudo git clone https://github.com/letsencrypt/letsencrypt
cd /usr/local/letsencrypt
sudo ./letsencrypt-auto --apache -d andachrental.co.uk`
6. This takes some time to load. Enter your email address, agree to the terms of service and set the entire website to force HTTPS. 
7. Then setup the crontab `sudo crontab -e` and add the below line:
8. `0 1 1 */2 * cd /usr/local/letsencrypt && ./letsencrypt-auto certonly --apache --renew-by-default --apache -d andachrental.co.uk >> /var/log/andachrental.co.uk-renew.log 2>&1`
9. Then setup Webmin so that the certificate works as well. Login to webmin (which will give you the insecurity warning), and select Webmin -> Webmin Configuration, then click the "Settings" gear in the top-left. Enter `/usr/local/letsencrypt-auto` as the "Full path to Let's Encrypt client command"
10. Then install VirtualMin. 
11. ??

## Add Expires Tags for Images
1. `sudo a2enmod expires`
2. `sudo nano /etc/apache2/sites-available/default-ssl.conf` file and paste this at the bottom:
3. 
`<IfModule mod_expires.c>
ExpiresActive on
ExpiresDefault "access plus 30 seconds"
ExpiresByType text/html "access plus 15 days"
ExpiresByType image/gif "access plus 1 months"
ExpiresByType image/jpg "access plus 1 months"
ExpiresByType image/jpeg "access plus 1 months"
ExpiresByType image/png "access plus 1 months"
ExpiresByType text/js "access plus 1 months"
ExpiresByType text/javascript "access plus 1 months"
</IfModule>`
4. Remove the server signatures by pasting the below into the bottom of /etc/apache2/apache2.conf
`ServerSignature Off
ServerTokens Prod`