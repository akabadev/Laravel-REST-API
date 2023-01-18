# 📚 Repositories

Le Repository Pattern est une stratégie d'abstraction de l'accès aux données aux différentes ressources de la base de
données.

Dans notre cas ici, pour simplifier, l'accès aux données de la base est délégué à une class qui se du stockage et de la
récupération des données, celle-ci est indépendante de l'endroit d'où on l'utilise.

Les repositories se situent dans le dossier `app/Repository` depuis la racine du projet.

La procedure de création d'un nouveau repository pour un `model` est la suivante:

1. Création l'Interface repository du model
2. Création la classe concrete du Repository
3. Résoudre l'Injection de dépendance
4. Cas pratique

Dans la suite de cette procedure, nous prétendrons l'existance d'un model nommé `Example`
pour lequel nous souhaitons créer un Repository.

## 1) Création de l'Interface du Repository

Rendez-vous dans le dossier `app/Repository/Contracts/Interfaces`, et créer y l'interface du nouveau Repository si
celui-ci est inexistant.

La règle de nommenclature est le nom du modele suivi de `RepositoryInterface`. Dans notre cas cela
donne `ExampleRepositoryInterface`.

Créez en suite l'interface du repository en étendant le Repository de base, comme ceci:

```php
<?php

namespace App\Repository\Contracts\Interfaces;

interface ExampleRepositoryInterface extends RepositoryInterface
{
    //
}
```

## 2) Création la classe concrete du Repository

Rendez-vous dans le dossier `app/Repository`, et créer y l'implémentation de votre interface.

La règle de nommenclature de votre class est le nom du modele suivi de `Repository`. Dans notre cas, cela
devient `ExampleRepository`.

Deux possibilités s'offrent à vous:

### (a). Création standard

```php
<?php

namespace App\Repository;

use App\Repository\Contracts\Interfaces\ExampleRepositoryInterface;
use App\Repository\Contracts\Repository;

/**
 * Class ExampleRepository
 * @package App\Repository
 */
class ExampleRepository extends Repository implements ExampleRepositoryInterface
{
    //
}
```

### (b). Customisation avancée

```php
<?php

namespace App\Repository;

use App\Models\Model;
use App\Repository\Contracts\Interfaces\ExampleRepositoryInterface;
use App\Repository\Contracts\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

/**
 * Class ExampleRepository
 * @package App\Repository
 */
class ExampleRepository implements ExampleRepositoryInterface
{
    //
    /**
     * @param array $filter
     * @return Arrayable|Collection|AbstractPaginator
     */
    public function index(array $filter = []): Arrayable|Collection|AbstractPaginator
    {
        // TODO: Implement index() method.
    }

    /**
     * @param array $attributes
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Builder|\Illuminate\Database\Eloquent\Model
    {
        // TODO: Implement create() method.
    }

    /**
     * @param int $id
     * @param bool $orFail
     * @return Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, bool $orFail = false): Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement find() method.
    }

    /**
     * @param Model|int $model
     * @param array $attributes
     * @return bool|int
     */
    public function update(int|Model $model, array $attributes = []): bool|int
    {
        // TODO: Implement update() method.
    }

    /**
     * @param Model|int $model
     * @param bool $force
     * @return bool
     */
    public function delete(int|Model $model, bool $force = false): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return bool
     */
    public function export(): bool
    {
        // TODO: Implement export() method.
    }

    /**
     * @param Model|Collection|Arrayable $data
     * @return array
     */
    public function format(Collection|Model|Arrayable $data): array
    {
        // TODO: Implement format() method.
    }

    /**
     * @return callable
     */
    public function formater(): callable
    {
        // TODO: Implement formater() method.
    }
}

```

## 3. Résoudre l'Injection de dépendance

Dites à Laravel comment injecter la bonne implémentation de votre repository interface.

Renseignez dans le fichier `app/Providers/RepositoryServiceProvider.php` le code ci-dessous:

```php
/**
 * Register services.
 *
 * @return void
 */
public function register() 
{
    // Ajouter y la ligne ci-dessous
    $this->app->singleton(ExampleRepositoryInterface::class, ExampleRepository::class);
}
```

Euuuuuh, c'est tout.

## 4. Cas pratique

Pour utiliser votre repository, vous servir de helpers, les injections de dépendance pour charger votre repository.

### (a). Injection de dépendance dans un constructeur / methods

```php
class SuperExampleClass
{
    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
```

```php
public function examples(ExampleRepositoryInterface $repository)
{
    return response()->json($repository->index());
}
```

### (b). Fabriquez le repository à la demande

Dans n'importe quel endroit de votre code

```php
$repository = app(ExampleRepositoryInterface::class);
```

OU

```php
$repository = app()->make(ExampleRepositoryInterface::class);
```

## Allez plus loin

Lisez la documentation de Laravel:
[Service Container](https://laravel.com/docs/8.x/container#binding-basics)

