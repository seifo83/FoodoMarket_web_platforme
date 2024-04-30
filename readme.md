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
### Cache-clear

```bash
make:cc='symfony console c:c'

```
### Yarn

```bash
make:yarn='yarn encore dev'

```
### Tests

```bash
 php bin/phpunit  --testdox
make:filter='symfony php bin/phpunit --filter'
make:testphpunit='symfony php bin/phpunit --filter'
make:couverage='symfony php bin/phpunit --coverage-html var/log/test/test-coverage'
```

### PHP Codesniffer => phpcs

```bash
source ~/.bashrc
 make:phpcs='phpcs -v --standard=PSR12 --ignore=./src/Kernel.php ./src'
 make:fix='~/.composer/vendor/bin/phpcbf --standard=PSR12'
```

### PHP Stan => phpStan

```bash
source ~/.bashrc
make:stan='vendor/bin/phpstan analyse'
```
