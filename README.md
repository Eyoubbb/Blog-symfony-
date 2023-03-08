# Projet Blog #
## Technologies utilisées ##

* PHP (requis)
* Composer (requis)
* Symfony (requis)
* MySQL
* NodeJS
* Docker et Docker-Compose
* Tailwind CSS
## Prérequis ##

* Avoir installé Docker et Docker-compose
* Avoir installé Composer
* Avoir installé NodeJS
* Utiliser le CLI Symfony
## Installation ##
Avant de démarrer notre environnement de test, il nous faut cloner le projet et installer toutes les libraries.

Commencer par cloner le projet: ``https://forge.univ-lyon1.fr/p2109841/blog-jeremy-eyoub.git``  

Une fois cela fait, ouvrir le projet dans un IDE.

Dans un nouveau terminal, installer toutes les librairies avec les deux commandes suivantes:

* ``npm install``
* ``composer install``
## Lancement: ##
Pour que notre environnement de test soit prêt, il nous faut lancer plusieurs service:

* Lancer le serveur WEB integré au CLI Symfony
* Lancer la base de données avec docker-compose
* Insérer les tables et le jeu de test
* Lancer le script watch de NodeJS (pour TailWind CSS)

Lancer le serveur symfony avec la commande du CLI:  

* ``symfony serve -d``  

Puis lancer la base de données mySQL avec docker compose:  
``docker-compose up -d database``

Une fois ces deux commandes exécutées, le serveur web est lancé et le conteneur contenant notre base de données est également lancé. 

La base de données est créée mais elle est vide.  
Executer la commande:  
``symfony console doctrine:migrations:migrate``  
 Les tables se basent sur la dernière version du modèle dans le dossier ``migrations/``

Pour finir, dans un nouveau terminal (toujours a la racine du projet)  

* ``npm run watch``
