# Shinigami API

#### URL
http://api.shinigami.buzaud.local:8080

#### PHPMyAdmin
http://api.shinigami.buzaud.local:8081


## Docker
### Lancement du docker
```
docker-compose build (optional)
docker-compose up -d
```
Pour voir les logs en direct
```
docker-compose logs -f
```

Ouverture d'un bash dans un container
```
docker-compose exec [container] bash
ex: docker-compose exec php bash
```
### Installation des dépendances
```
docker-compose run composer composer install
```

## Base de données
#### Connection
1. host : localhost
2. port : 3306
3. user : root
4. mdp : [empty]

#### Doctrine création db
```
docker-compose run composer php bin/console doctrine:database:create --if-not-exists
```

#### Doctrine migration db
```
docker-compose run composer php bin/console doctrine:migrations:diff
docker-compose run composer php bin/console doctrine:migrations:migrate
```

#### Doctrine Fixtures db
```
docker-compose run composer php bin/console doctrine:fixtures:load
```


## Generation des pdf
1. Installer le programme WkHtmlToPdf (https://wkhtmltopdf.org/downloads.html)
2. Mettre en place les variables `WKHTMLTOPDF_PATH` et `WKHTMLTOIMAGE_PATH` suivant l'OS

Linux
```
WKHTMLTOPDF_PATH=/usr/local/bin/wkhtmltopdf
WKHTMLTOIMAGE_PATH=/usr/local/bin/wkhtmltoimage
```

Windows
```
WKHTMLTOPDF_PATH="C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"
WKHTMLTOIMAGE_PATH="C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"
```

