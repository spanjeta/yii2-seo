Seo Manager
===========
Seo Manager for every Site

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist spanjeta/yii2-seo "*"
```

or add

```
"spanjeta/yii2-seo": "*"
```

to the require section of your `composer.json` file.

###Migration


Run the following command in Terminal for database migration:

Linux/Unix:
```
yii migrate/up --migrationPath=@vendor/spanjeta/yii2-seo/migrations
```

Windows:
```
yii.bat migrate/up --migrationPath=@vendor/spanjeta/yii2-seo/migrations
```


Usage
-----

```

Add to modules
```php
    'modules' => [
        'seomanager' => [
            'class' => 'spanjeta\modules\seomanager\Module',
        ],
    ]
```

Pretty Url's ```/seomanager```

No pretty Url's ```index.php?r=seomanager```



### content

To get content to every page you can use in the seomanger the content field.
To print out the content you must you this in your view.

```php
<?php
/** @var Module $module */
$module = Yii::$app->getModule('seomanager');
$conten = $module->getContent();

if ($conten !== null): ?>
    <div class="container">
        <?= $conten; ?>
    </div>
<?php endif; ?>
```
