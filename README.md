# Zentheme Pikadate
This module provides a Wordpress customizer Control based on the [Pikaday Datepicker](https://github.com/dbushell/Pikaday) project. The module is available via `composer` so it can be added to a plugin or theme. 

The Pikaday Datepicker has a pretty comprehensive range of config options, most of which are available to the Control, you can check them out on the [Pikaday Project](https://github.com/dbushell/Pikaday) page on Github.

#### Install with composer
Download and install Composer by following the [official instructions](https://getcomposer.org/download/).
For usage, see [the documentation](https://getcomposer.org/doc/).

Run the following in your terminal to install the module with [Composer](https://getcomposer.org/).

```
$ composer require zentheme/wpikaday
```

As this project uses [PSR-4](http://www.php-fig.org/psr/psr-4/) autoloading you will need to use Composers autoloader.

## Using the Control
Below is a simple example of how the control might be used in a plugin or theme. The example assumes that the `vendor/autoload.php` file has already been included.

```php
use Zentheme\Customizer\Pikaday\PikadayControl;

// Projects customizer configuration
add_action( 'customize_register', function( $wpCustomize ) {
    // Add a section...
    $wpCustomize->add_section( 'pikaday_section', [
        'title' => 'Pikaday Section'
    ] );
    
    // Then a setting...
    $wpCustomize->add_setting( 'pikaday_setting', [
        'default' => '',
        'transport' => 'postMessage'
    ] );
    
    // ...and finally add the Pikaday control
    $wpCustomize->add_control( 
        new PikadayControl( $wpCustomize, 'pikaday_control', [
            'label' => 'Pikaday Calendar',
            'section' => 'pikaday_section',
            'settings' => 'pikaday_setting',
            'position' => 'bottom right',   // position the  datepicker
            'format' => 'MMMM Do YYYY'      // define the date format
            // ... add any other valid Pikaday params here
        ] )
    );
} );
```

## Notes
* Licensed under the [MIT License](https://github.com/zentheme/wpikaday/blob/master/LICENSE)
* Maintained under the [Semantic Versioning Guide](http://semver.org)

## Author

**John Dundon**

* [zenthe.me](http://zenthe.me)