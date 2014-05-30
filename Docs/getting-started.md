## Getting Started

Once the provider is registered, you can start using loading config files easily.  Out of the box, the ConfigServiceProvider is able to load three different types of files:

- **YAML** (.yml)
- **INI** (.ini)
- **PHP** (.php)

The loading of configuration files is done using the `ConfigManager` class.  This is a service which can be accessed at `$app['config.manager']`.  To access configurations, the service `$app['config']` is used.

### Loading a Config File

After the provider is registered, configuration files can be loaded using the configuration manager.  For example, we'll use a made up config file named `AppConfig.yml`, which is structured as follows:

    # AppConfig.yml
    app_config:
        environment: debug
        database: my_database

In order to load this config file, it can be added to the list of files to load using the `config.manager` service:

    $app['config.manager']->addFile('AppConfig.yml', 'app');

This will add the `AppConfig.yml` file to the list of files to be loaded. 

#### Loading YAML Files

The loader will know to load a YAML file when the extension `.yml` is detected.

#### Loading INI Files

The loader will know to load an INI file when the `.ini` extension is detected.

#### Loading PHP Files

The loader will know to load a PHP file when the `.php` file is detected.  The PHP file should should return an array:

    <?php

    return [ 'test' => 'value' ]; 

### Reading Configuration Values

The configuration files are lazy loaded; this means that they are not loaded until the `config` service is used:

    $config = $app['config'];

Because of this, it is necessary to make sure that all configuration files are added before the `config` service is accessed.

Above, when we added the configuration file `AppConfig.yml`, we added it with the type `app`.  This means the configuration values can be read from the `app` index under the config service: 

    $appConfig = $app['config']['app'];

	$environment    = $appConfig['environment'];
    $database       = $appConfig['database'];

Loading two files of the same type will result in the values being merged together in the array.  The merge is done using the native PHP function `array_merge_recursive`.

<p />

<div style="text-align:center">
  <a href="usage.md">&lt; Prev (Usage)</a> | <a href="definitions.md">Next (Validation & Definitions) &gt;</a>
</div>