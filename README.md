
# POC Filtre Doctrine

POC d'utilisation des filtres doctrine


## Init

```
php bin/console doctrine:database:create
```

```
php bin/console doctrine:schema:update --force
```

```
php bin/console app:init
```

## Doctrine

1. Création filtre dans `src/Doctrine/someFilter.php`.

2. configuration doctrine : 

```yaml
# config/packages/doctrine.yaml

doctrine:
    orm:
        filters:
            some_filter:
                class: App\Doctrine\SomeFilter
                enabled: true
                parameters:
                    filter_value: '%filter_value%'
```

```yaml
# config/services.yaml

parameters:
    filter_value: "filter_A"
```

## Autre exemple de filtre, avec annotation 

=> `src/Doctrine/someOtherFilter.php`

Permet de choisir les filtres dynamiquement avec des annotations (ex `@Filter(column="client_id")`)
 au lieu d'avoir le filtre en dur dans le `someFilter.php`.
 
```php
/**
 * @ORM\Entity(repositoryClass="App\Repository\TrucRepository")
 * @Filter(column="filter")
 */
class Truc
{
    public $id;
    public $filter;
    public $data;
    // ...
}
```

## Exemples d'utilisation

### Récupération de toutes les données

```php
$em->getRepository(Truc::class)->findAll();
```

Le filtre `WHERE ((t0.filter = 'filter_A'))` est automatiquement ajouté

```json
[
    {
      "id": 1,
      "filter": "filter_A",
      "data": "random_data_e5106f1cf6494996bef7a4cf15f712b9"
    },
    {
      "id": 2,
      "filter": "filter_A",
      "data": "random_data_e365109c19816df46bdcfc8fe8ad88b6"
    },
    {
      "id": 3,
      "filter": "filter_A",
      "data": "random_data_7c3460bdc2b84bd9da46e0b7f8e704c1"
    },
    {
      "id": 4,
      "filter": "filter_A",
      "data": "random_data_2b98410f21ef4cde53c7b45bb5ad2a1c"
    },
    {
      "id": 5,
      "filter": "filter_A",
      "data": "random_data_daca42b8cf9df755b3f7b99b01d94c06"
    }
]
```

### Récupération des données de ID > 3

```php
$em->getRepository(Truc::class)->searchWhereIdGreaterThan(3);
```

Le filtre `WHERE ((t0.filter = 'filter_A'))` est automatiquement ajouté également

```json
[
    {
      "id": 4,
      "filter": "filter_A",
      "data": "random_data_2b98410f21ef4cde53c7b45bb5ad2a1c"
    },
    {
      "id": 5,
      "filter": "filter_A",
      "data": "random_data_daca42b8cf9df755b3f7b99b01d94c06"
    }
]
```

### Requête sur toutes les données, filtre explicitement désactivé

```php
$em->getFilters()->disable("some_filter");
$em->getRepository(Truc::class)->findAll();
```

Aucun filtre n'est ajouté

```json
[
    {
      "id": 1,
      "filter": "filter_A",
      "data": "random_data_e5106f1cf6494996bef7a4cf15f712b9"
    },
    {
      "id": 2,
      "filter": "filter_A",
      "data": "random_data_e365109c19816df46bdcfc8fe8ad88b6"
    },
    {
      "id": 3,
      "filter": "filter_A",
      "data": "random_data_7c3460bdc2b84bd9da46e0b7f8e704c1"
    },
    {
      "id": 4,
      "filter": "filter_A",
      "data": "random_data_2b98410f21ef4cde53c7b45bb5ad2a1c"
    },
    {
      "id": 5,
      "filter": "filter_A",
      "data": "random_data_daca42b8cf9df755b3f7b99b01d94c06"
    },
    {
      "id": 6,
      "filter": "filter_B",
      "data": "random_data_6dfbf20ff99c98fd538ca65c5b7f7922"
    },
    {
      "id": 7,
      "filter": "filter_B",
      "data": "random_data_7594cd6a7c3640ddb1f99f17356a4ace"
    },
    {
      "id": 8,
      "filter": "filter_B",
      "data": "random_data_99b0ffebb586cf2e779adbcd1de906e5"
    },
    {
      "id": 9,
      "filter": "filter_B",
      "data": "random_data_08073caf35091eda6322bb04520651bc"
    },
    {
      "id": 10,
      "filter": "filter_B",
      "data": "random_data_7082873a59f9f2a8d5a7a55696ce4fc3"
    },
    {
      "id": 11,
      "filter": "filter_C",
      "data": "random_data_b1a9b4338e6c77bc1b944d7f01cfd181"
    },
    {
      "id": 12,
      "filter": "filter_C",
      "data": "random_data_6c2a97f40a7bfc0514db61a59c9d4863"
    },
    {
      "id": 13,
      "filter": "filter_C",
      "data": "random_data_64e3de01d09efcc0419de9fa94ddc89e"
    },
    {
      "id": 14,
      "filter": "filter_C",
      "data": "random_data_5b28af11b6630f409b2648b999c7385c"
    },
    {
      "id": 15,
      "filter": "filter_C",
      "data": "random_data_1b53c6bc77f5f4dfca3b4cd38e6227aa"
    }
]
```
