# Canvas pour le TP noté : Gestion d'une bibliothèque
## Modifier le `.env`
`DATABASE_URL=mysql://user:password@163.172.173.245:3306/db_name
`
## Schema de base
![schema.png](./schema.png)

- `Library` : Bibliothèque
- `Reader` : Lecteur
- `Category` : Genre d'un ouvrage
- `Book` : Référence d'un ouvrage
- `Copy` : Exemplaire d'un ouvrage
- `Lending` : Fiche de pret d'un exemplaire d'un ouvrage
### SQL
[Fichier SQL](./sql.sql)
## Lancement du projet
- `git clone`
- `composer install`
- `cd public`
- `php -S localhost:8000`


## Etape 1 : Mapper toutes les tables
Il est possible de mapper en mode `OneToMany` mais cela n'est pas forcement utile pour la suite

## Etape 2 : Créer les routes pour toutes les entités selon le modèle suivant
- `GET` `/`
- `PUT` `/`
- `GET` `/{id}`
- `PATCH` `/{id}`
- `DELETE` `/{id}`

**NE PAS OUBLIER LES SERIALIZERS**

## Etape 3 : Ressoudre les problèmes suivants
#### L'ensemble des personnes ayant emprunté un livre : `/book/{id}/readers`
#### Nombre de livres disponibles dans la bibliothèque : `/library/{id}/books`
#### Disponibilité d'un livre : `/library/{id}/book/{id}/stocks`