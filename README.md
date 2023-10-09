# Wargame

Le projet est un site internet de "Banque ISEN Nantes" qui comporte des vulnérabilités de différents niveaux qu'il vous faudra retrouver. 

Le site internet possède différentes fonctionnalités notamment celle de créer un compte sur le site de la banque.

On peut également se connecter au site pour consulter son compte en banque, les transactions qui ont eut lieu et effectuer des virements d'argent aux autres clients de la banque.

Pour déployer l'image, il existe 2 méthodes :
- Depuis le dépôt Github
- Depuis le Docker Hub (la plus simple)
## Variables utilisateurs

Pour vous connecter aux comptes utilisateurs, vous aurez besoin de différents identifiants/mot de passe

Login: `lucas.jules@isen.com`
Mot de passe: `test123`

Login: `bouju.guillaume@isen.com`
Mot de passe: `guiguilamenace`

Login: `sicot.françois@isen.com`
Mot de passe: `faf`




## Déployer le site internet depuis Github

Cloner le projet

```bash
  git clone https://github.com/JulesLcs/wargame-bank.git
```

Aller dans le répertoire du projet

```bash
  cd wargame-bank-main
```

Renommer le fichier git

```bash
  mv _git .git
```

Construire l'image 

```bash
  docker build -t wargame-bank-website .
```

Démarrer le container

```bash
  docker run -p 80:80 -d wargame-bank-website
```


## Déployer le site internet depuis Docker Hub

Récupérer l'image docker

```bash
  docker pull guillaumebj/wargame:wargame-bank-website
```

Démarrer le container

```bash
  docker run -p 80:80 -d guillaumebj/wargame:wargame-bank-website
```


## Flags

Le site internet comporte des vulnérabilités volontaires. Il y en a 4 et sont nommées de la forme suivante : `Flag{secure_token}`

Votre objectif : toutes les trouver !
