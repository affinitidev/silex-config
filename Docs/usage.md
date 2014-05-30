## Usage

Enabling the ConfigServiceProvider in your project is just as easy as any other Silex provider!  Simply register it with the `\Silex\Application` object:

    $app->register(new Affiniti\Config\SilexConfigProvider(), array(
        'config.paths' = [ __DIR__ . '/config' ]
    ));

Now, all config objects can be accessed through Pimple.

### Parameters

The `SilexConfigProvider` can take a few parameters when calling the Silex `register` function.  These parameters configure the way that the Config provider works:

- `config.paths`: This is an array of paths to locate config files.  **Required**.
- `config.cache.path`: This is the directory where the cache files will be stored.  This should be writable by the application.
- `config.cache.type`: This is the type of cache for the Cache Factory to produce.  Default is `disabled`.

### Config Name

You can specify a different config name for the ConfigServiceProvider to use.  This can be used in case if different naming is required, for example if an existing `config` exists in your app.  

This will change all references of `config` to your custom config name.  This is done by passing the new config name into the constructor of the service provider:

	new Affiniti\Config\ConfigServiceProvider('my.config');

This will cause all services and parameters to now be prefixed by `my.config` instead of `config`, for example:

    $manager = $app['my.config.manager'];
	$app['my.config.cache.enabled'] = true;
    $testConfig = $app['my.config']['testConfig'];

### Services

---
#### `config.manager` 

The manager of various configuration definitions.

##### Methods

`ConfigManager::addConfig($file, $definition = null);`

`ConfigManager::addDefinition(Affiniti\Config\Definition\DefinitionInterface $definition);`

`ConfigManager::addLoader(Affiniti\Config\Loader\LoaderInterface $loader);`

`ConfigManager::addCacheFactory($type, \Closure $cacheFactory);`

##### Notes
- If a provider wants access to the `config.manager` service, it can be accessed through the `ConfigInitEvent` of the Silex dispatcher.  See the [Usage with Providers](providers.md) section for more details.  This is useful if a provider wants to add its own definitions, loaders, or caches.

##### Example
  `$app['config.manager']->addConfig('myfile.yml');` 

---
#### `config`
The service which holds loaded config values.  

##### Methods

This service has no methods, it acts as an `\ArrayAccess` container.

##### Notes
- Configuration files will not be loaded until the first time the `config` service is accessed.
- All configuration files, definitions, loaders, and cache factories should be defined before the `config` service is accessed.
- Attempting to get an undefined top-level config entry (e.g. `$app['config']['db']`) will result in a `Affiniti\Config\Exception\ConfigNotFound` exception being raised.  An undefined non top-level config entry (e.g. `$app['config']['db']['host']`) will result in a PHP  undefined index error.

##### Example
`$dbConfig = $app['config']['db'];`

<p />

<div style="text-align:center">
  <a href="installation.md">&lt; Prev (Installation)</a> | <a href="getting-started.md">Next (Getting Started) &gt;</a>
</div>