# Shinigami API
####URL
http://api.shinigami.buzaud.local:8080
####PHPMyAdmin
http://api.shinigami.buzaud.local:8081
## Docker
### Lancement du docker
```
docker-compose build (optional)
docker-compose up -d
```

###Ouverture d'un bash dans un container
```
docker-compose exec [container] bash
ex: docker-compose exec php bash
```

## Base de données
### Connection
1. host : localhost
2. port : 3306
3. user : root
4. mdp : [empty]

### Doctrine création db
```
docker-compose exec db bash
cd /usr/local/apache2/htdocs/
php bin/console doctrine:databasse:create
```

### Doctrin migration db
```
docker-compose exec db bash
cd /usr/local/apache2/htdocs
php bin/console doctrine:database:diff
php bin/console doctrine:database:migrate
```

### Doctrine Fixtures db
```
docker-compose exec db bash
cd /usr/local/apache2/htdocs
php bin/console doctrine:fixtures:load
```
