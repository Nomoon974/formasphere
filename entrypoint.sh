#!/bin/bash
set -e

# Mise à jour des permissions pour /var/www/html et tous les sous-dossiers
chown -R www-data:www-data /var/www/html/

# Exécution de la commande par défaut ou de celle spécifiée
exec apache2-foreground
