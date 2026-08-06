#!/bin/bash
# Fix write permissions for www-data (e.g. for config_ok file in public/)
chown -R www-data:www-data /var/www/html 2>/dev/null || true
chmod 777 /var/www/html/public 2>/dev/null || true

# Lancement du serveur SMTP factice en arrière-plan
php /usr/local/bin/smtp_server.php &

# Lancement de Apache au premier plan
apache2-foreground
