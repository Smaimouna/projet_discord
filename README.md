Discord – Application de messagerie Symfony
Application de messagerie inspirée de Discord, développée avec le framework Symfony.

Fonctionnalités
Inscription
Connexion
Déconnexion
Création de salons
Modification de salons
Suppression de salons
Envoi de messages
Consultation des messages
Suppression automatique des messages lors de la suppression d'un salon
Technologies utilisées
Symfony 8
PHP 8.4
Doctrine ORM
SQLite
Twig
Symfony Security
Git
Base de données
L'application utilise SQLite.

Aucun serveur de base de données n'est nécessaire. Le fichier de base de données est créé automatiquement dans :

var/data.db
lors de l'exécution des migrations.

Installation
Depuis le dossier du projet :

composer install
php bin/console doctrine:migrations:migrate --no-interaction
Lancement
Avec Symfony CLI
symfony server:start
Avec le serveur PHP intégré
php -S 127.0.0.1:8000 -t public
Ouvrir ensuite :

http://127.0.0.1:8000
dans le navigateur.

Utilisation
Créer un compte sur /register (pseudo, email, mot de passe).
Se connecter.
Créer un salon.
Ouvrir un salon.
Envoyer des messages.
Test des restrictions
Créer un second compte (par exemple dans une fenêtre de navigation privée).

Ce second utilisateur pourra :

consulter les salons ;
envoyer des messages ;
mais ne pourra pas :

modifier un salon créé par un autre utilisateur ;
supprimer un salon créé par un autre utilisateur.
Une erreur 403 - Accès refusé sera affichée.

Comptes utilisateurs
Aucun compte n'est préchargé.

Il est nécessaire de créer un compte afin de tester l'application.

Configuration de la base de données
La connexion est définie dans le fichier .env :

DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
Les migrations Doctrine se trouvent dans le dossier :

migrations/
Structure du projet
Élément	Emplacement
Entités (User, Salon, Message)	src/Entity/
Contrôleurs	src/Controller/
Formulaires	src/Form/
Templates Twig	templates/
Styles CSS	assets/styles/app.css
Migrations Doctrine	migrations/
Dépannage
Erreur « could not find driver »
Activer l'extension :

pdo_sqlite
dans le fichier php.ini, puis redémarrer le serveur.

Réinitialiser la base de données
Supprimer :

var/data.db
puis exécuter :

php bin/console doctrine:migrations:migrate --no-interaction
Auteur
Sokhna
