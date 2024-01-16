A simple and easy to use php routing library

How to use

Install using composer
```bash
composer require retamayo/vector
```
Note: do the following steps on the index file.

Include the autoloader
```php
include "vendor/autoload.php";
```

Use the namespace
```php
use Retamayo\Vector\Vector;
```

Get Instance of Vector
```php
$vector = Vector::getInstance();
```

Run the router
```php
$vector->run();
```

Add routes to the newly generated routes file
```php
// add static routes
$this->get('/route_name', 'path_to_file');
```

```php
// add callback routes
$this->get('/route_name', function () {
    echo "Hello World!";
});
```

```php
// add dynamic routes
$this->get('/route_name/{slug}', function ($slug) {
    echo "Hello " . $slug;
});
```

You can edit the default 404 rout in the routes config file
Note: when working with the config files do not change any name of the defined constants you can change their value but not the name.
```php
define('DEFAULT_404', 'path_you_like');
```