# Andach Game Rental
## Summary
This is a PHP application to run a website that will let you rent video games out. 

## Installation Instructions for Ubuntu 16.04.3 (x64)
### Install Apache, mySQL, PHP, etc.
1. Install the PHP7.2 and webmin repos
    1. `sudo add-apt-repository -y ppa:ondrej/php && sudo apt-get update`
2. Install Apache, PHP and mySQL
    1. `sudo apt-get install -y apache2`
    2. `sudo apt-get install -y php7.2 zip unzip php7.2-curl php7.2-mbstring php7.2-dom php7.2-gd php7.2-mysql php7.2-zip composer mariadb-server`
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
3. `chown www-data:www-data /var/www/html`
4. `sudo -u www-data git clone https://github.com/useaquestion/andach-gamerental`

### Install from Composer
1. `cd /var/www/html/andach-gamerental`
1. `composer install --no-dev` (omit the --no-dev flag if you're setting up a dev environment of course)
1. `php artisan key:generate` (and at this point set up the SQL password appropriately)
7. `php artisan migrate:refresh --seed`.
8. `php artisan storage:link`
6. `sudo service apache2 restart`

## Installing an SSL Certificate
1. Enable SSL for apache. 
2. `sudo a2enmod ssl`
3. `sudo a2ensite default-ssl.conf`
4. `sudo nano /etc/apache2/sites-available/default-ssl.conf` and change the DocumentRoot parameter accordingly. 
4. `sudo service apache2 restart`
5. Clone Let's Encrypt information into your /usr/local directory `cd /usr/local
sudo git clone https://github.com/letsencrypt/letsencrypt
cd /usr/local/letsencrypt
sudo ./letsencrypt-auto --apache -d andachgames.co.uk`
6. This takes some time to load. Enter your email address, agree to the terms of service and set the entire website to force HTTPS. 
7. Then setup the crontab `sudo crontab -e` and add the below line:
8. `0 1 1 */2 * cd /usr/local/letsencrypt && ./letsencrypt-auto certonly --apache --renew-by-default --apache -d andachrental.co.uk >> /var/log/andachrental.co.uk-renew.log 2>&1`

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