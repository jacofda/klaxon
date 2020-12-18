
## Installation

Via Composer

``` bash
$ composer require jacofda/klaxon
```

## Usage

``` bash
$ composer require Jacofda/Klaxon
$ php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
$ php artisan vendor:publish --provider="Jacofda\Klaxon\KlaxonServiceProvider" --tag="klaxon.migrations"
$ php artisan vendor:publish --provider="Jacofda\Klaxon\KlaxonServiceProvider" --tag="klaxon.trans"
$ php artisan vendor:publish --provider="Jacofda\Klaxon\KlaxonServiceProvider" --tag="klaxon.config"
$ php artisan storage:link
$ php artisan queue:table

$ php artisan migrate
$ composer dump-autoload

$ php artisan db:seed --class=CitiesSeeder
$ php artisan db:seed --class=CountriesSeeder
$ php artisan db:seed --class=ExemptionsSeeder
$ php artisan db:seed --class=SettingsSeeder
$ php artisan db:seed --class=StarterSeeder

```
