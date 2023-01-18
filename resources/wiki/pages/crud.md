# 🎲 CRUD Simple

## 1) Création du Model et du controller
`php artisan make:model EntityName -all`
Cette commande génère un model, une migration, une factory, un seeder et controller

## 2) Ajouter les routes associés aux controllers
Ouvrir le fichier `app/routes/api.php` et rajouter les routes correspondant au CRUD
 Ex:`Route::apiResource('entitynames', EntityNameController::class);`

 ## 3) Creation des Form Request 
 Il faut créer les form requests et ajouter la validation nécessaire à de la commande:
 `php artisan make:request EntityNameRequest`

 ## 4) Génerer la documentation 
 `php artisan l5-swagger:generate` permet de mettre à jour la documentation

