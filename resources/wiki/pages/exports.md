# 📤 Exports

Pour lancer une tache d'exportation des resources, veuillez suivre ces étapes :

## 1) Trouvez/Créez le bon process

A) Recherchez le process associé à la tache d'export que vous souhaitez créer **(model `Process`)**.

Pour le faire, vous pouvez utiliser le helper `Process::findOrCreateWithInvokable(VOTRE_JOB::class);`. Et assurez-vous
que le job indiqué existe.

Dans le cas des exports des resources des vue, vous pouvez simplement faire ceci :

```php
$process = Process::findOrCreateWithInvokable(ExportViewableJob::class);
```

B) Si le process que vous souhaiter utiliser n'existe pas encore, vous pouvez le créer comme pour les models standard
avec:

```php
$process = Process::create([
    // voir les champs `fillables`du model
]);
```

## 2) Créez et lancez la nouvelle tache

Maintenant que vous avez le bon `process`:

1) Recherchez ou créer le fichier de configuration de l'export

Ce fichier de configuration est personnalisable pour chaque client (tenant).

Rendez-vous dans le dossier `tenants/Basic/config/exports/votre-config.json`.

Ce fichier doit avoir a la structure suivante :

```json5
{
    "format": {
        // <-- les formats supportés
        "default": "csv",
        "csv": {
            "separator": ";"
        },
        "pdf": {}
    },
    "columns": {
        // <-- les colonnes autorisé à être exporté
        "champ": {
            // <-- Colonne dans le model (ou base de données)
            "label": "Libellé du champs"
            // <-- Libellé du champs qui sera visible dans le document
        }
    }
}
```

2) Créez votre nouvelle tache d'export

```php
$task = ExportTask::create([
    'process_id' => $process->id,
    'status_id' => ExportTask::EXPORT_PENDING_ID(),
    'payload' => [
        'filters' => ['column' => 'value'], // les filtres
        'repository' => ExampleRepositoryInterface::class,
        'service' => $service, // csv, pdf,...
        'config' => 'exports/votre-config.json'
    ],
    'available_at' => now(),
    'comment' => 'Exportation des Pingouins',
]);
```

3) Mettez la tache sur la queue d'execution avec

```php
$task->queue();
```

## 3) Exécutez la tache avec

```bash
php artisan queue:work --queue=tasks
```
