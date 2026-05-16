#!/bin/bash

# Attendre que la base de données soit prête (optionnel mais recommandé)
echo "Attente de la base de données..."

# Exécuter les migrations de la base de données
echo "Exécution des migrations..."
php artisan migrate --force

# Vider et régénérer le cache
echo "Nettoyage du cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lancer Apache en arrière-plan
echo "Démarrage d'Apache..."
apache2-foreground
