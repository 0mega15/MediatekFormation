# Mediatekformation
## Dépot d'origine
https://github.com/CNED-SLAM/mediatekformation
## Présentation
Ce site, développé avec Symfony 6.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube.<br> 
Actuellement, seule la partie front office a été développée. Elle contient les fonctionnalités globales suivantes :<br>
![img1](https://github.com/user-attachments/assets/9c5c503b-738d-40cf-ba53-36ba4c0209e8)
## Les différentes pages modifié
### Page 2 : les formations
Cette page présente les formations proposées en ligne (accessibles sur YouTube).<br>
Au niveau des colonnes "formation", "playlist" et "date", 2 boutons permettent de trier les lignes en ordre croissant ("<") ou décroissant (">").<br>
Il est aussi possible de trier les 
Au niveau des colonnes "formation" et "playlist", il est possible de filtrer les lignes en tapant un texte : seuls les lignes qui contiennent ce texte sont affichées. Si la zone est vide, le fait de cliquer sur "filtrer" permet de retrouver la liste complète.<br> 
Au niveau de la catégorie, la sélection d'une catégorie dans le combo permet d'afficher uniquement les formations qui ont cette catégorie. Le fait de sélectionner la ligne vide du combo permet d'afficher à nouveau toutes les formations.<br>
Par défaut la liste est triée sur la date par ordre décroissant (la formation la plus récente en premier).<br>
Le fait de cliquer sur une miniature permet d'accéder à la troisième page contenant le détail de la formation.<br>
![img3](https://github.com/user-attachments/assets/bc033cf9-41a5-4cad-a268-8abb400965c5)
## Le back office
## Page Formation
Reprend les mêmes élément que le front office à l'exeption qu'il est possible d'ajouter de modifier et de supprimer des formations<br>
La création et la modification de playlist se fait via un formulaire<br>
## Page Playlist 
Reprend les mêmes élément que le front office à l'exeption qu'il est possible d'ajouter de modifier et de supprimer des playlists, la suppresion de playlist ne peut se faire que si elle ne contient aucune formation<br>
## Page Categorie
Page permettant d'ajouter ou de supprimer des catégories<br>
Il n'est pas possible d'ajouter 2 noms identique, ni de supprimer une catégorie déjà rataché à une formation
## Acces avec authentification
Il est possible d'acceder à la page de connexion à la partie administrative du site en modifiant l'url
