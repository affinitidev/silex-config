## Caching

In large, real-world applications, caching is a necessity.  It allows you to reduce the time spent reading files on-disk as well as validating configuration files.  The ConfigServiceProvider offers a simple single-file caching implementation to speed up your application.

### Enabling the Cache

To enable the cache, a type must be provided in the `$app['config.cache.type']` parameter.  The default value is `disabled`, which loads the `Affiniti\Config\Cache\Concrete\DisabledCache` class.  This is a cache implementation which always is expired, and doesn't write a cache.

### The PHP File Cache

There is one type of cache built in: the `php` cache.  This cache will load the cache implementation at 

    Affiniti\Config\Cache\Concrete\PhpCache

This cache can be used by setting the cache type to `php` when registering the provider:

    $app->register(new Affiniti\Config\SilexConfigProvider(), array(
        'config.paths'         = [ __DIR__ . '/config' ],
        'config.cache.type'    = 'php',
        'config.cache.path'    = __DIR__ . '/cache/config_cache.php'
    ));

The PHP File cache will dump the processed configuration array to a PHP file.  On subsequent requests, this PHP file will be included (instead of the configuration files being loaded and processed).

The `config.cache.php` parameter must also be specified.  This should point to a specific file where the cache should be read from and written to.  This file should be writable and readable by the web server running the Silex application.

**Important Note**: This implementation of the cache does not provide any expiration, since config files do not often change.  It is recommended that it not be used in development.  In production, the file should always be deleted whenever configurations are changed.

### Implementing a Custom Cache

Implementing a custom cache is fairly easy, the `Affiniti\Config\Cache\CacheInterface` interface must be implemented, which contains three methods:
	    
	interface CacheInterface {
	    public function expired();
	    public function write(array $data);
	    public function get();
	}

#### Creating a Cache Factory

Normally, a cache may require some kind of parameters to be instantiated - such as a database connection, or a file path.  The application only uses a single type of cache, so it is desirable to only load the one being used.  This is why Cache Factories are used.

A Cache Factory is an object that implements `Affiniti\Config\Cache\CacheFactoryInterface`.  This has two methods: `getType()` and `newInstance(\Silex\Application $app)`.  An implementation of a Cache Factory is available at `Affiniti\Config\Cache\CacheFactory`.  It allows the Cache Factory to be created using a closure:

    $cacheFactory = new CacheFactory('my_cache', 
        function(\Silex\Application $app) {
            return new MyCache();
        }
    );

The above code will create a factory with the type `my_cache`.  Once the factory is created, it can be registered using the `config.manager` service:

    $app['config.manager']->addCacheFactory($cacheFactory);

This cache implementation can now be used by setting the proper option:

    $app['config.cache.type'] = 'my_cache'; 

<p />

<div style="text-align:center">
  <a href="loaders.md">&lt; Prev (Loaders)</a> | <a href="providers.md">Next (Using With Providers) &gt;</a>
</div>