# Card
## Créer une carte
* Route : [/api/card/new](http://http://api.shinigami.buzaud.local/api/card/new) 
* Retour : Entité Card (src/Entity/Card.php)

------------------------------------------
Les attributs suivants doivent être renseignés:

1. {id_establishment}
2. {code_establishment}
```
{
  "_comment": "JSON Create Card",
  "establishment": "/api/establishments/{id_establishment}",
  "establishmentCode": {code_establishment}
}
```

Exemple :
```
{
  "_comment": "JSON Create Card",
  "establishment": "/api/establishments/1",
  "establishmentCode": 835
}
```



## Voir une carte

## Modifier une carte

## Supprimer une carte