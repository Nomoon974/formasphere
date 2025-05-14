# Formasphere

Formasphere est une plateforme web open‑source dédiée à la **création, gestion et suivi de formations**. Elle repose sur **Symfony 6**, **MySQL 8** et **Apache HTTP Server**, et embarque un hub **Mercure** pour la diffusion d’événements temps réel.

> Tout l’environnement est conteneurisé : un simple `docker compose up --build` suffit pour lancer l’application en local.

## Sommaire
- [Pré‑requis](#pré‑requis)
- [Installation rapide](#installation-rapide)
- [Gestion des assets front (Yarn)](#gestion-des-assets-front-yarn)
- [Commandes utiles](#commandes-utiles)
- [Migrations & jeu de données](#migrations--jeu-de-données)
- [Nettoyage](#nettoyage)
- [Contribuer](#contribuer)
- [Licence](#licence)

## Pré‑requis
| Outil | Version minimale | Testé avec |
|-------|------------------|------------|
| **Git** | 2.30 | 2.44 |
| **Docker Engine** | 20.10 | 24.0 |
| **Docker Compose** | 2.0 | 2.27 |
| **Node.js** | 18 LTS | (inclus dans le conteneur) |
| **Yarn** | 1.x | (inclus dans le conteneur) |

_Aucun de ces outils n’a besoin d’être installé sur votre machine — seul Docker suffit. Les exécutables Node & Yarn sont embarqués dans l’image `php_apache`._

## Installation rapide
```bash
# 1. Clonez le dépôt
git clone https://github.com/Nomoon974/formasphere.git
cd formasphere

# 2. Démarrez les conteneurs
docker compose up -d --build

# 3. (Facultatif) Suivez les logs
docker compose logs -f
```

Quelques secondes plus tard :

| Service | URL/Host | Description |
|---------|----------|-------------|
| Application Symfony | <http://localhost:8090> | Interface front & API |
| MySQL | `localhost:3306` | Base de données `formasphere` |
| Adminer | <http://localhost:8081> | Gestion BD via web |
| Mercure hub | <http://localhost:1337> | Diffusion SSE/WebSocket |
| Mailpit | <http://localhost:8025> | Boîte mail de test |

Ces ports sont exposés dans `docker-compose.yml` citeturn4file0.

## Gestion des assets front (Yarn)
Formasphere utilise **Symfony UX/Encore (Webpack)** pour compiler ses assets (JS/TS, SCSS/Tailwind, images). Les dépendances NPM sont donc requises.

> Le conteneur **php_apache** inclut Node 18 LTS et Yarn 1.x – aucune installation supplémentaire côté hôte.

```bash
# Installer les dépendances front (une fois)
docker compose exec php_apache yarn install

# Watcher + Hot Module Replacement pour le dev
docker compose exec php_apache yarn dev

# Build optimisé pour la production
docker compose exec php_apache yarn build
```

Les fichiers générés se trouvent dans `public/build/` et sont versionnés (hash) pour assurer un cache‑busting efficace.

## Commandes utiles
```bash
# Entrer dans le conteneur PHP
$ docker compose exec php_apache bash

# Installer les dépendances PHP
$ composer install

# Lancer les migrations
$ php bin/console doctrine:migrations:migrate

# Créer un utilisateur administrateur (exemple)
$ php bin/console app:create-admin user@example.com password
```

## Migrations & jeu de données
Exécutez la commande suivante pour préparer la base _et_ injecter des données d’exemple :

```bash
docker compose exec php_apache bash -c "php bin/console doctrine:migrations:migrate --no-interaction && php bin/console doctrine:fixtures:load --no-interaction"
```

Cette étape :
1. applique la structure de base ;
2. insère un **jeu de données de démo** (formations, sessions, comptes) contenu dans `src/DataFixtures/`.

> Les fixtures créent notamment un compte **administrateur**. Consultez les classes fixtures pour les identifiants exacts ou créez votre propre compte via `php bin/console app:create-admin`.

## Nettoyage
```bash
# Arrêter les services
docker compose down

# Supprimer volumes + images intermédiaires
docker compose down -v --rmi local
```
```bash
# Arrêter les services
docker compose down

# Supprimer volumes + images intermédiaires
docker compose down -v --rmi local
```
