ECF - SESSION JUIN 2022 - TITRE PRO DEVELOPPEUR WEB ET WEB MOBILE

Sujet - Cha�ne d'h�tels Hypnos
Par Louise Le Ray

-----------------------------------------------------------


D�marche pour le d�ploiement en local :

1- T�l�charger le fichier .zip que vous trouverez sur ce repository. Cliquez sur le bouton vert 'Code' puis sur le choix 'Download zip'.

2- Une fois fait, d�zippez le fichier, puis ouvrez-le en tant que nouveau projet dans votre IDE favori. 

3-Trouvez le fichier .env.local. Dedans, aux lignes d�di�es � la base de donn�e, entrez les informations d'identification et de mot de passe que vous utilisez dans votre SGBD (ex: phpmyadmin). 

4- Ouvrez la ligne de commande de votre IDE, puis commencez par taper la commande suivante "symfony console doctrine:migrations:migrate" (si vous utilisez Symfony CLI), sinon tapez "php bin/console doctrine:migrations:mirgate".
TADAA toutes les tables n�cessairent apparaissent !!

5- D�marrez le serveur symfony ainsi que le sass loader afin de pouvoir voir le site, tapez "symfony server:start", puis dans un nouvel onglet de terminal de commande, tapez "npm run watch". 

6- Vous pouvez d�s maintenant remplir les tables de la BDD tel un r�el utilisateur du site. Mais avant, il vous cr�er votre user Admin. Pour cela, inscrivez-vous sur la page "inscription". Une fois fait, vous pourrez modifier le r�le de ce nouveau User directement dans votre SGBD, en y inscrivant ["ROLE_ADMIN"] � la place des [] vides. 

7- Connectez-vous gr�ce aux identifiant de l'admin que vous venez de cr�er. Maintenant il est temps d'ajouter vos �tablisements au site ! Cliquez sur "Acc�der � l'administration". Ici, remplissez le formulaire trouv� en cliquant sur "Add Establishment" pour ajouter un nouvel �tablissement. 

8- Vous pouvez �galement ajouter des managers. Il suffit de cliquer sur "Managers" puis "Add Manager" dans votre Dashboard d'administration. 

9- Maintenant que vous avez ajout� les �tablissements et les managers qui leurs sont associ�s. Utilisez les identifiants d'un manager pour vous connecter. Une fois sur l'espace membre, cliquez sur l'option "G�rer mon �tablissement". 
Vous pouvez maintenant cliquer sur "Ajouter une suite" et remplir les informations de votre nouvelle suite. 

10- Il manque quelques photos � cette suite non ? 
Retournez sur la page "G�rer mon �tablissement". Vous retrouvez la suite que vous venez de cr�er ainsi qu'une option "ajouter une gallerie". Vous avez tout compris ! Cliquez dessus et t�l�chargez les trois jolies photos qui accompagneront la photo principale de votre suite. 

11 - Voil�, le site est d�ploy� et rempli en local. Vos �tablissements et suites apparaissent !


D�ploiement en ligne :

1- Exportez votre base de donn�e en utilisant le terminal de commande SQLShell avec la commande mysqldump. 
"mysqldump -u root -p nomdelaBDD > nomDuFichier.sql" et entrez votre mot de passe. 

2- Vous pouvez maintenant importez ce fichier sur votre h�bergueur. J'ai utilis� Hostinger, je suis donc all�e sur la page bases de donn�es et j'ai cr�e une nouvelle base de donn�e dans laquelle j'ai import� le fichier pr�c�demment cr��. 

3- Dans le projet symfony, trouvez le fichier .env, modifiez la ligne "ENV=DEV" par "ENV=PROD"; ainsi que les informations de connexion � la base de donn�es (sur Hostinger, vous les trouvez dans la liste de vos base de donn�es). 

4- Via un client FTP comme FileZila, connectez vous � votre h�bergeur gr�ce aux informations FTP que vous trouverez sur votre espace sur le site de votre h�bergeur. 

5- Une fois connect�, vous pouvez transf�rer les fichiers du projet dans le dossier "public_html" de votre h�bergeur. 

6- N'oubliez pas de supprimer le ficher ".env.local" des fichiers de votre projet une fois h�berg� en ligne. En g�n�ral vous pouvez acc�der � vos fichiers directement sur votre espace du site h�bergeur. Sinon, supprimez-le du c�t� h�bergeur sur FileZila ou autre client FTP que vous utilisez. 

7- Cr�ez votre domaine ou sous-domaine et le site est mainteant d�ploy� en ligne. 

BONUS : 8- Si vous n'avez pas cr�� d'administrateur en local, vous pouvez vous r�f�rer � l'�tape 6 du d�ploiement en local. Une fois en ligne, vous pouvez g�n�ralement acc�der � votre base de donn�e via un SGBD (sur hostinger il s'agit de phpMyAdmin). Vous pourrez donc modifier le r�le de l'administrateur manuellement via ce SGBD en ligne. 