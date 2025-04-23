# Projet Final – Méthodes d’Authentification  
### IC3 S2 – Efrei 2024/2025  
### Groupe : Mathéo Lecoeur, Louis Volard, Gautier MERCAT, Arthur LAVERAN
### Repository forké depuis : [https://github.com/amdouni/authmethods](https://github.com/amdouni/authmethods)

## 🔐 1. Connexion sécurisée à GitHub & réparation erreurs de lancement 

- Utilisation de **code space** pour se connecter au repository forké.
- Connexion sécurisée via compte GitHub et clé SSH automatiquement gérée par code space.
- Commit et push réalisés depuis code space avec succès.
- vérification de npm, composer sont install. Nétant pas le cas, on les à installer 
- Creation de fichier $web-font-path avec https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap 

### 🔑 Authentification via google (OAuth2)

- Instauration API google oAuth

- Resolution d'une erreur d'acces a l'application car code space a changer le port sans prévenir. IL à alors fallut modifier les api google
---
- Création d'un espace https://console.cloud.google.com/ et création d'un client d'authentification. Récupération de la clef et du secret
- Modification de la page de login : retrait du tableau avec les mots de passe et ajout du bouton de connection google
- Création des routes pour acceder jusqu'au service google (./connect/google) puis pour le retour des données depuis google (./login/check-google)
- Implémentation d'un **service Symfony** pour récupérer les données google et la vérification de la connection
- Implémentation d'un **service Symfony** pour la gestion des erreurs d'enregistrement avec messages d'erreur sur la page principale
- Hachage du secret google pour plus de sécurité

## 🌤 3. Intégration de l’API OpenWeatherMap – Nouvelle page météo

- Création d’un compte sur [OpenWeatherMap.org](https://openweathermap.org) et génération d’une API Key.
- Implémentation d’un **service Symfony** pour se connecter à l’API météo.
- Creation d'une page d'appel API 
- Creation d'une clé de service Yaml 
- Creation d'une page de template Twing
- Affichage de la météo actuelle pour une ville définie (ex : Paris) :
  - Température
  - Conditions météo (ex. : Ensoleillé, Pluie)
  - Icône illustrant la météo


## 🗂️ Principaux Fichiers modifiés / ajoutés

- `.env.local` : stockage de différentes variables
- `config/packages/security.yaml` : gestion des firewall et des routes pour permettre la communication avec l'API de connection google
- `src/Controller/WeatherController.php` : nouvelle page météo
- `src/Service/WeatherService.php` : communication avec l’API OpenWeatherMap
- `templates/weather/index.html.twig` : page affichant la météo
- `src/Security/OAuthUserProvider.php` : service d'authentification et de récupération des données de google
- 'config/packages/hwi_oauth.yaml' :configuration de l’authentification OAuth2
- `templates/security/login.html.twig` : modification de la page de login
- ...

---

