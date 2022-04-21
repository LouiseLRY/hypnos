ECF - SESSION JUIN 2022 - TITRE PRO DEVELOPPEUR WEB ET WEB MOBILE

Sujet - Chaîne d'hôtels Hypnos
Par Louise Le Ray

-----------------------------------------------------------


Démarche pour le déploiement en local :

1- Télécharger le fichier .zip que vous trouverez sur ce repository. Cliquez sur le bouton vert 'Code' puis sur le choix 'Download zip'.

2- Une fois fait, dézippez le fichier, puis ouvrez-le en tant que nouveau projet dans votre IDE favori. 

3-Trouvez le fichier .env.local. Dedans, aux lignes dédiées à la base de donnée, entrez les informations d'identification et de mot de passe que vous utilisez dans votre SGBD (ex: phpmyadmin). 

4- Ouvrez la ligne de commande de votre IDE, puis commencez par taper la commande suivante "symfony console doctrine:migrations:migrate" (si vous utilisez Symfony CLI), sinon tapez "php bin/console doctrine:migrations:mirgate".
TADAA toutes les tables nécessairent apparaissent !!

5- Démarrez le serveur symfony ainsi que le sass loader afin de pouvoir voir le site, tapez "symfony server:start", puis dans un nouvel onglet de terminal de commande, tapez "npm run watch". 

6- Vous pouvez dès maintenant remplir les tables de la BDD tel un réel utilisateur du site. Mais avant, il vous créer votre user Admin. Pour cela, inscrivez-vous sur la page "inscription". Une fois fait, vous pourrez modifier le rôle de ce nouveau User directement dans votre SGBD, en y inscrivant ["ROLE_ADMIN"] à la place des [] vides. 

7- Connectez-vous grâce aux identifiant de l'admin que vous venez de créer. Maintenant il est temps d'ajouter vos établisements au site ! Cliquez sur "Accéder à l'administration". Ici, remplissez le formulaire trouvé en cliquant sur "Add Establishment" pour ajouter un nouvel établissement. 

8- Vous pouvez également ajouter des managers. Il suffit de cliquer sur "Managers" puis "Add Manager" dans votre Dashboard d'administration. 

9- Maintenant que vous avez ajouté les établissements et les managers qui leurs sont associés. Utilisez les identifiants d'un manager pour vous connecter. Une fois sur l'espace membre, cliquez sur l'option "Gérer mon établissement". 
Vous pouvez maintenant cliquer sur "Ajouter une suite" et remplir les informations de votre nouvelle suite. 

10- Il manque quelques photos à cette suite non ? 
Retournez sur la page "Gérer mon établissement". Vous retrouvez la suite que vous venez de créer ainsi qu'une option "ajouter une gallerie". Vous avez tout compris ! Cliquez dessus et téléchargez les trois jolies photos qui accompagneront la photo principale de votre suite. 

11 - Voilà, le site est déployé et rempli en local. Vos établissements et suites apparaissent !


Déploiement en ligne :

1- Exportez votre base de donnée en utilisant le terminal de commande SQLShell avec la commande mysqldump. 
"mysqldump -u root -p nomdelaBDD > nomDuFichier.sql" et entrez votre mot de passe. 

2- Vous pouvez maintenant importez ce fichier sur votre hébergueur. J'ai utilisé Hostinger, je suis donc allée sur la page bases de données et j'ai crée une nouvelle base de donnée dans laquelle j'ai importé le fichier précédemment créé. 

3- Dans le projet symfony, trouvez le fichier .env, modifiez la ligne "ENV=DEV" par "ENV=PROD"; ainsi que les informations de connexion à la base de données (sur Hostinger, vous les trouvez dans la liste de vos base de données). 

4- Via un client FTP comme FileZila, connectez vous à votre hébergeur grâce aux informations FTP que vous trouverez sur votre espace sur le site de votre hébergeur. 

5- Une fois connecté, vous pouvez transférer les fichiers du projet dans le dossier "public_html" de votre hébergeur. 

6- N'oubliez pas de supprimer le ficher ".env.local" des fichiers de votre projet une fois hébergé en ligne. En général vous pouvez accéder à vos fichiers directement sur votre espace du site hébergeur. Sinon, supprimez-le du côté hébergeur sur FileZila ou autre client FTP que vous utilisez. 

7- Créez votre domaine ou sous-domaine et le site est mainteant déployé en ligne. 

BONUS : 8- Si vous n'avez pas créé d'administrateur en local, vous pouvez vous référer à l'étape 6 du déploiement en local. Une fois en ligne, vous pouvez généralement accéder à votre base de donnée via un SGBD (sur hostinger il s'agit de phpMyAdmin). Vous pourrez donc modifier le rôle de l'administrateur manuellement via ce SGBD en ligne. 