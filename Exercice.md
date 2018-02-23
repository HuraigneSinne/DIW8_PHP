

Dans un fichier index.php :
- Créer un formulaire en methode post
 input : login
 input : mot de passe
 bouton : se connecter
 
Dans un script php authenticate.php
- Créer un tableau $users avec les colonnes 'login', 'password' et 3 enregistrements
exemple : 'john', 'motdepasse'

| id | login | password  |
| ------------- |:----------------:| -----:|
| 0 | john | motdepasse |
|.....|||

Si le login/mot de passe ne sont pas corrects remettre le formulaire de connexion avec un message d'erreur

Si le login/mot de passe sont corrects rediriger vers la page user.php
```
header("Location: user.php");
die();
```

Dans la page user.php 
- créer un tableau php qui liste les informations des utilisateurs (nom, prenom, email, date de naissance)
- Aficher le contenu de ce tableau en HTML
```
<table>
  <tr>
    <td></td>
    <td></td>
  </tr>
</table>
```
OU en bootstrap pour les plus fous !

