# Makefile pour la gestion de conteneurs Docker

up: ## Lance tous les conteneurs
	docker-compose up -d

down: ## Arrête et supprime tous les conteneurs
	docker-compose down

build: ## Construit ou reconstruit les services
	docker-compose build

logs: ## Affiche les logs des conteneurs
	docker-compose logs -f

ps: ## Liste tous les conteneurs
	docker-compose ps

restart: ## Redémarre tous les conteneurs
	docker-compose restart

ssh-php: ## Se connecte au conteneur PHP
	docker-compose exec php_apache bash

ssh-db: ## Se connecte au conteneur MySQL
	docker-compose exec mysql bash

help: ## Affiche cette aide
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

exec-php: ## Exécute une commande dans le conteneur PHP (utilisation : make exec-php cmd="votre_commande")
	docker-compose exec php_apache $(cmd)

exec-db: ## Exécute une commande dans le conteneur MySQL (utilisation : make exec-db cmd="votre_commande")
	docker-compose exec mysql $(cmd)
