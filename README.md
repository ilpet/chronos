# Chronos CMS

---

A developer friendly headless CMS built by [C4studio](http://c4studio.ro).

---

## Installation

It's as easy as:

    composer require c4studio/chronos

After composer has run add following lines to the providers[] array in ```app/config/app.php```:

```php
...
Chronos\Scaffolding\ScaffoldingServiceProvider::class,
Chronos\Content\ContentServiceProvider::class,
...
```


### Install dependencies

You also need to add the service providers for all the dependencies in ```app/config/app.php```:

```php
...
Collective\Html\HtmlServiceProvider::class,
Intervention\Image\ImageServiceProvider::class,
Laravel\Passport\PassportServiceProvider::class,
Lavary\Menu\ServiceProvider::class,
...
```

And also add the class aliases in the ```$aliases[]``` array:

```php
...
'Form' => Collective\Html\FormFacade::class,
'Html' => Collective\Html\HtmlFacade::class,
'Image' => Intervention\Image\Facades\Image::class,
'Menu' => Lavary\Menu\Facade::class,
...
```


### Publish assets

Next we need to publish all the assets belonging to Chronos:

	php artisan vendor:publish --tag=public

Note 1: if you would like to overwrite existing files, use the --force switch
Note 2: if you wish to only publish Chronos assets, you might want to use the --provider flag.


### Prepare User model

Next we need to prepare the User model to work with Chronos.

1. First, let's move our User model into the App\Models namespace. It's just more organized this way.

```
mkdir app/Models
mv app/User.php app/Models/User.php
```

2. Open User.php and change the namespace to ```namespace App\Models;```

3. Add the ChronosUser trait to our model:

```php
...
use Notifiable, ChronosUser;
...
```

4. Next, add some values to the appends[] array:

```php
...
/**
 * The accessors to append to the model's array form.
 *
 * @var array
 */
protected $appends = ['endpoints', 'name'];
...
```

5. Lastly, don't forget to tell Laravel where to look for our User model. Change the line in ```app/config/auth.php``` to:

```php
...
'model' => App\Models\User::class,
...
```


### Set APP_URL

Chronos requires you to set APP_URL in your .env file

```
APP_URL=https://chronos.ro
```


### Run migrations

Almost done. We need to run the migrations and seed our database:

```
php artisan migrate
php artisan db:seed --class=\\Chronos\\Scaffolding\\Seeds\\DatabaseSeeder
php artisan db:seed --class=\\Chronos\\Content\\Seeds\\DatabaseSeeder
```


### Set up task scheduling

Chronos runs a couple of tasks in the background, so you will need to set up task scheduling by adding the following to your Cron entries on your server:

```
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```


### Install and configure Passport

1. Add the following to the ```boot()``` method in ```app/Providers/AuthServiceProvider```

```
Passport::routes();
```

2. In ```app/Http/Kernel.php```, add the following to the ```$middlewareGroups[]``` array:

```
...
\Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
...
```

3. Change the driver to ```passport``` in ```config/auth.php```

```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
        'hash' => false,
    ],
],
```

4. Run the install script of laravel/passport to generate our encryption keys:

```
php artisan passport:install
```

5. Finally, create a new token in the Chronos admin, ```Settings/Access tokens```.


---
[http://c4studio.ro](http://c4studio.ro)

P.S.: You're awesome for being on this page