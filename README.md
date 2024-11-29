# Sylius Product Setting Plugin

## Install

1. Run `composer require gtt/sylius-product-setting-plugin dev-main`
Add to repositories list:
```json
{
    "type": "vcs",
    "url": "https://github.com/gettads/sylius-product-setting-plugin.git"
}
```
2. Add to `config/bundles.php`:

```php
    Gtt\SyliusProductSettingPlugin\GttSyliusProductSettingPlugin::class => ['all' => true],
```

3. Run `php bin/console doctrine:migrations:diff`, `php bin/console doctrine:migrations:migrate` and `php bin/console cache:clear`


