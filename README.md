<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="#">
    <img src="https://cdn.discordapp.com/attachments/782900445077045258/921528902621487144/logo.png" alt="Logo" width="200">
  </a>

  <h1 align="center"><b>Symfony TP</b></h1>

  <p align="center">
    <br />
    <a href="https://github.com/sbdjs/website"><strong>Découvrir »</strong></a>
    <br />
    <br />
    <a href="https://github.com/Altaryss/symfony-gestion-tp">Accueil</a>
    ·
    <a href="https://github.com/Altaryss/symfony-gestion-tp/issues">Signaler un Bug</a>
    ·
    <a href="https://github.com/Altaryss/symfony-gestion-tp/issues">Suggestion</a>
  </p>
</p>

<!-- GETTING STARTED -->
## Getting Started

Ce projet est à un but éducatif et donc potentiellement instable merci de ne pas tenter de le déployer en public.

### Prérequis

Ceci est une liste des étapes à suivre pour l'installation et le bon fonctionnement du site.

* Créer un dossier (le choix de l'emplacement vous reviens)
  ```sh
  mkdir symfoProjet
  ```
 
### Installation

1. Ouvrir le dossier crée
   ```sh
   cd ./symfoProjet
   ```

2. Cloner le repos
   ```sh
   git clone https://github.com/symfony-gestion-tp.git
   ```
3. Installer les extensions
   ```sh
   composer install
   ```
En cas d'erreur d'installation pensez à supprimer les dossiers vendor et à recommencer depuis l'étape 1
4. Initialiser la base de donnée
   https://symfony.com/doc/current/doctrine.html#configuring-the-database

<!-- USAGE EXAMPLES -->
## Usage

Ce site permet de gérer des évenement ou des personnes ajoutent de l'argent et détermine qui doit quels sommes à qui.

1. Lancer le serveur
   ```sh
   symfony serve:start
   ```
