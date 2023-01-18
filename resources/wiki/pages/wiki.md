# Rédaction du Wiki

Cette décrit la procedure à suivre pour la rédaction d'une page sur ce Wiki

## Création de la rubrique

Pour créer une rubrique sur le menu, rendez-vous sur le fichier `resources/wiki/payload.json`.

Le contenu de ce fichier ressemble à ceci:
```json
{
    "default": {
        "slug": "index"
    },
    "pages": [
        {
            "title": "Accueil",
            "slug": "index",
            "file": "index.md"
        },
        {
            "title": "Redaction du Wiki",
            "slug": "wiki",
            "file": "wiki.md"
        }
    ]
}
```

Vous pouvez donc vous inspirer des rubriques existantes pour créer la nouvelle rubrique.

__Remarque:__

Le nom fichier `file` doit correspondre au `slug` suivi de l'extension `.md` 


## Contenu de la page

Rendez-vous dans le dossier `resources/wiki/pages` et 
créer y un fichier ayant le nom du champ `file` que 
vous avez spécifié précédemment dans `payloads.json`  


#
