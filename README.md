# LOGIWEB - PROCEDURE D'INSTALLATION

## CLONAGE DU PROJET

```bash
git checkout [CHOOSE THE RIGHT BRANCH]
```

### 0) PREREQUIS

Voici la liste de prerequis de Laravel 8. Tous ne sont pas requis en développement, mais il est récommandé de les avoirs tout de même. 

- `PHP ^8.0`
- Extension `ext-http`
- Extension `BCMath`
- Extension `Ctype`
- Extension `Fileinfo` 
- Extension `JSON`
- Extension `Mbstring` 
- Extension `OpenSSL` 
- Extension `PDO`
- Extension `Tokenizer`
- Extension `XML`

Plus d'information:  [Server Requirements](https://laravel.com/docs/8.x/deployment#server-requirements)


### 1) INSTALLATION DES PACKAGES:

- Installation des packages ``composer``:

```bash
composer install
composer dump-autoload
```

- Installation des packages ``node``:

```bash
yarn install
yarn prod
# OU AVEC NPM
npm install
npm run prod
```

### 2) CONFIGURATION DU PROJET:

Il faut fortement recommendé de lire la documentation des commandes ``artisan``, en tapant ``php artisan``
ou ``php artisan list`` pour tous les lister.

#### #) VARIABLES D'ENVIRONNEMENT:

Créez un fichier ``.env`` et copiez y le contenu du fichier ``.env.example``.

Ou tout simplement utilisez la commande :

```bash
cp .env.example .env
```

Puis renseigner les variables:

---

- *``APP_ENV``*: Environnement d'execution de l'application. Values possibles: ``local``, ``developpment``
  ou ``production``
- *``APP_DEBUG``*: Activer ou non le mode de debuggage de l'application. Values possibles: ``true``, ``false``
- *``APP_URL``*: URL d'accès de l'aaplication de l'application.
- *``APP_KEY``*: Générer une clé de l'application, permet de renforcer la sécurité de l'application. Lancez la commande:

```bash
php artisan key:generate
```

---

- *``DB_CONNECTION``*: SGBD de la base de données. Supporté par défaut: `mysql`, `pgsql` et `sqlite`
- *``DB_HOST``*: Host de la base de données
- *``DB_PORT``*: Port de connexion à la base de données
- *``DB_DATABASE``*: Nom la base de données
- *``DB_USERNAME``*: Nom d'utilisateur de connexion à la base de données.
- *``DB_PASSWORD``*: Mot de passe utilisateur de la base de données

---

- *``SANCTUM_STATEFUL_DOMAINS``*: Domains autorisés à se connecter à l'application, utilisé par Sanctum 🔐.

---

- *``LOGIWEB_API_URL``*: URL qui pointe sur une ancienne API logiweb, pour le portage à l'API `api/v0`.

---

### 3) LANCER LES MIGRATIONS DE LA BASE DE DONNÉES

Pour effacer des fichiers cache :

```bash
php artisan optimize:clear
php artisan cache:clear
```
Pour lancer les migrations de la base de données :

```bash
php artisan app:migrate-and-seed
```

### 4) LANCEZ LE SERVEUR INTERNE DE LARAVEL

Démarrer le serveur interne de Laravel avec la commande :
```bash
php artisan serve
```

**[⚠️ ATTENTION]** : Il faut également vous assurez que le paramètre `IDENTIFY_TENANT_BY_SUBDOMAIN=false` dans votre fichier `.env`  


### 5) DOCUMENTATION DE L'API (SWAGGER) OU DES PROCESS
Pour accéder à la documentation de l'API,   [http://(VOTRE_URL)/api/documentation](http://(VOTRE_URL)/api/documentation)
Pour accéder à la documentation des process,   [http://(VOTRE_URL)/wiki](http://(VOTRE_URL)/api/wiki)

### 6) LISTE DES ROUTES

Pour lister les routes de l'application:

```bash
php artisan route:list
```

Pour plus de lisibilité lors de l'affichage des routes: rajouter le flag `-h` à la commande pour voir les options qui s'offrent à vous.

<u>Ex:</u>
Pour afficher uniquement les routes commençant par `api/v1` en condensé:

```bash
php artisan route:list --path=api/v1 -c
```

### 7) UTILISATION DE L'API

Pour pouvoir utiliser correctement l'API, vous devez vous assurer que le header `Accept: application/json` est bien existant.

Si vous utiliser postman pour vos tests, il est plus simple de rajouter en pre-script de votre collection ceci :
```js
pm.request.headers.add({
  key: 'accept',
  value: 'application/json'
});
```


### 8) LANCEMENT DES JOBS
php artisan q:w --queue=tasks