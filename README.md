Discord – Application de messagerie Symfony

Application de messagerie inspirée de Discord, développée avec le framework Symfony.

I.Fonctionnalités
-Inscription
-Connexion
-Déconnexion
-Création de salons
-Modification de salons
-Suppression de salons
-Envoi de messages
-Consultation des messages
-Suppression automatique des messages lors de la suppression d'un salon
II.Technologies utilisées
-Symfony 8
-PHP 8.4
-Doctrine ORM
-SQLite: la base de données est SQLite, aucun serveur de base de données à installer ni à configurer. Le fichier de base est créé automatiquement dans var/data.db lors des migrations.
-Twig
-Symfony Security
-Git

III.Installation
Depuis le dossier du projet :
composer install
php bin/console doctrine:migrations:migrate --no-interaction
IV.Lancement
-Avec Symfony CLI :
symfony server:start
-Avec le serveur PHP intégré :
php -S 127.0.0.1:8000 -t public
-Ouvrir ensuite http://127.0.0.1:8000 dans le navigateur.

V-Utilisation
-Créer un compte sur /register (pseudo, email, mot de passe).
-Créer un salon, l'ouvrir et envoyer des messages.
-Tester les restrictions : créer un second compte (fenêtre de navigation privée). Il peut lire les salons et y écrire, mais ne peut ni modifier ni supprimer le salon d'un autre utilisateur (erreur 403).

Aucun compte n'est préchargé : il faut s'inscrire pour tester l'application.

VI.Configuration de la base de données(SQLite)
La connexion est définie dans le fichier .env :

DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

Les migrations Doctrine se trouvent dans le dossier migrations/.

VII.Structure du projet
Élément	--> Emplacement:
Entités (User, Salon, Message) -->	src/Entity/
Contrôleurs (inscription, connexion, salons)	--> src/Controller/
Formulaires	--> src/Form/
Templates Twig	--> templates/
Styles CSS	--> assets/styles/app.css
Migrations -->	migrations/
