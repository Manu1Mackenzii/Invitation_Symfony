# Invitation_Symfony
Un système d'invitation basé sur l'API REST en Symfony 

# Invitation_Symfony
Un système d'invitation basé sur l'API REST en Symfony (front-back)

#Repo git ajouté
git init
git add .
git commit -m "initialisation du projet"
git remote add origin https://github.com/Manu1Mackenzii/Invitation_Symfony.git
git push origin master

#Ajouter doctrine au projet
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev

#Créez un nouveau fichier nommé "Dockerfile"  avec sa config

# Ajouter l’image docker de la BD: il nous suffit d’appeler l’image dans docker-compose.yml 
Ajouter php, db: postgres et adminer

#Ajout des variables d’environnement
.env

# Exécuter 
Commande docker-compose up

# Exécuter 
composer install

# Création de l’entité Invitation
php bin/console make:entity

# Dossier [tests]
composer require --dev symfony/phpunit-bridge

#les fixtures
docker compose exec php composer require orm-fixtures --dev

# les faker
docker compose exec php  composer require fakerphp/faker --dev



