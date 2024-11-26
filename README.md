# Sylius Product Setting Plugin

## Install

1. Run `composer require gettads/sylius-product-setting-plugin`
Add to repositories list:
```json
{
    "type": "git",
    "url": "git@gitlab.gtt.cz:sylius/gtt-sylius-product-setting-plugin.git"
}
```
2. Add to `config/bundles.php`:

```php
    Gtt\SyliusProductSettingPlugin\GttSyliusProductSettingPlugin::class => ['all' => true],
```

3. Add to routes.yaml:
```
gtt_sylius_product_setting:
    resource: '@GttSyliusProductSettingPlugin/Resources/config/routing.yml'
```
4. Run `php bin/console doctrine:migrations:diff`, `php bin/console doctrine:migrations:migrate` and `php bin/console cache:clear`

## Tests
### Initialization
```bash
composer install
yarn --cwd tests/Application install
yarn --cwd tests/Application encore dev
tests/Application/bin/console doctrine:database:create --env test
tests/Application/bin/console doctrine:schema:create --env test
```

### Run
```bash
composer check
```
 - You may need to configure your local .env or run `composer tests` with inline parameters, 
like:  `APP_ENV=test DATABASE_URL=mysql://sylius:pass@mysql_sylius:3306/sylius_test composer tests`
