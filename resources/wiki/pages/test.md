<br/>
  
# 🔧 Test

**1. Présentation des tests :**

Dans le cadre de la refonte de l’outil Logiweb, la mise en place de tests est nécessaire afin de
vérifier le bon fonctionnement des API développées. 
Afin de vérifier leurs bons fonctionnements, les tests écrits peuvent être exécutés via 2 outils :
***postman*** et ***newman***. 
Pour ce projet de refonte, plusieurs ressources existent :

***Addresses | beneficiaries | customers | listings | orders | account/password | processes |***
        ***products | tokens | services | users | view/beneficiaries***


Les tests ont été réalisés pour les API suivantes : 

* **[POST] Store a newly created resource in storage :** *Permet de créer une ressource spécifique
qui sera ensuite ajoutée à la base de données*. 
* **[GET] Display a listing of the resource :** *Affiche un listing complet de l’ensemble éléments
d’une ressource contenu dans la base de données (par exemple pour la ressource ‘user’, l’api va
retourner l’ensemble des utilisateurs présents dans la base de données)*.
* **[GET] Display the specified resource :** *Retourne un élément précis d’une ressource.*
* **[PUT] Update the specified resource in storage :** *Met à jour un élément précis de la ressource*
* **[PATCH] Update the specified resource in storage :** *Met à jour un élément précis de la ressource*
* **[DELETE] Remove the specified resource from storage :** Supprime un élément précis de la ressource.*

Ces API sont présentes dans toutes les ressources et sont adaptées en fonction de la ressource en
question.

Il y a également des tests sur des API de connexion, déconnexion et mise à jour de mot de passe : 
* **[POST] Sign in :** *Permet de se connecter, et retourne un ‘token d’identification’ qui sera utilisé
par la suite par l’ensemble des autres API.*
* **[POST] Sign out :** *Permet de se déconnecter*
* **[POST] Request password change :** *Envoie un lien afin de modifier son mot de passe.*
* **[POST] Update password :** *Modifie le mot de passe.*

Pour chacune des API, les tests vérifient : 
* Le code statut **200** → réussite de la requête 
* Temps de réponse < **500 ms**
* Le retour de la requête soit bien un **JSON**
* Success égale à **‘true’**
* Vérification au niveau du contenu du JSON qui est retourné (vérification de certains champs (le
champ doit être non **‘null’** et non **‘undefined’**.

**2. Exécution via postman :**

Pour exécuter le scénario de test via ‘postman’, il faut importer le fichier
*‘test_API.postman_collection.json’* de la branche ‘integration’ qui se trouve dans le dossier
*‘ressources/doc/tests/postman’.*


On obtient par la suite dans ***‘My Workspace’*** une collection qui contient l’ensemble des scénarios
qui ont été développés. En cliquant sur la collection, un onglet s’ouvre, et il est possible de lancer le
scénario de test en cliquant sur *‘run’*.

Après avoir lancé les tests sur la collection, on obtient un résultat pour chaque requête, et qui nous
indique les tests qui ont été exécutés sans problème, et ceux qui ont échoué. De plus, pour conserver
ces résultats, il est possible de les exporter sous la forme d’un fichier json.


**3. Exécution via en ligne de commande (newman) :**

Pour exécuter la collection via newman, il faut déjà installer l’outil grâce à la commande 
```console
"npm install -g newman"
```

Si vous ne disposez pas de npm, il faut l’installer, sinon il existe une autre alternative qui est présentée sur le site de la documentation de <a href="https://learning.postman.com/docs/running-collections/using-newman-cli/command-line-integration-with-newman/">newman</a>. 
Ensuite, il faut se rendre dans le dossier du projet, et plus précisement là ou se trouve la collection ainsi que l’environnement de postman : ***‘logiweb_v2\resources\doc\tests\postman’***.

Il faut ensuite exécuter la commande : 
```console
newman run test_API.postman_collection.json -e Logiweb.postman_environment.json
```
Après avoir exécuté la commande, on obtient les résultats auxtests pour chacunes des requêtes. Il y a également un tableau qui récapitule le nombre de requêtes
qui ont été exécutées, ainsi que les ***‘failure’***. En dessous de ce tableau, il y a le détail des ‘failure’.

Il est également possible d’avoir un report en html des résultats en tapant la commande :
```console
newman run test_API.postman_collection.json -e Logiweb.postman_environment.json -r htmlextra
```

Mais il faut au préalable installer le reporter avec la commande : 
```console
npm install -g newman-reporter-htmlextra
```


**Pour plus d’informations :**

* <a href="https://learning.postman.com/docs/getting-started/introduction/">Documentation postman</a>. 
* <a href="https://learning.postman.com/docs/running-collections/using-newman-cli/command-line-integration-with-newman/">Documentation newman</a>. 
* <a href="https://www.npmjs.com/package/newman-reporter-htmlextra">Documentation pour le reporter htmlextra (newman)</a>. 
