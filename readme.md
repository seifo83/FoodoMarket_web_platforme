# FoodoMarket

une plateforme en ligne dédiée à la restauration, offrant une large gamme de produits frais de qualité provenant de fournisseurs de confiance.


## Environnement de développement

### Pré-requis

* PHP 8.0.30
* Symfony 5.4.38
* Composer
* Symfony CLI
* Docker
* Docker-compose
* nodejs & npm


### Lancer l'environnement de developpement

```bash
composer install
npm install
npm run build
docker-compose up -d
symfony serve -d
```

### Lancer les tests

```bash
 php bin/phpunit  --testdox
 APP_ENV=test symfony php bin/phpunit --coverage-html var/log/test/test-coverage

```

### Lancer  php_codesniffer phpcs

```bash
source ~/.bashrc
 make:phpcs='phpcs -v --standard=PSR12 --ignore=./src/Kernel.php ./src'
 make:fix='~/.composer/vendor/bin/phpcbf --standard=PSR12'
```

### Lancer  php_stan phpStan

```bash
source ~/.bashrc
make:stan='vendor/bin/phpstan analyse'
```
