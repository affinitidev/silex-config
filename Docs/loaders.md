## Loaders

Loaders allow different types of configurations to be processed.  Their job is to load a given configuration into an array.  The ConfigServiceProvider comes standard with 3 loader implementations:

- YAML
- INI
- PHP

This guide will help you create and register a custom loader.

### The `LoaderInterface`

A valid loader must implement the `Affiniti\Config\Loader\LoaderInterface`, which extends the [Symfony LoaderInterface](http://api.symfony.com/2.4/Symfony/Component/Config/Loader/LoaderInterface.html).  It adds one extra method onto the Symfony interface:

    public function setLocator(\Symfony\Component\Config\FileLocatorInterface $locator)

This function allows the `FileLocator`  to be passed in at runtime - don't worry, this is handled by the provider.

### The `Loader` Base Class

A base class which provides common convenience methods can and implements the `Affiniti\Config\Loader\LoaderInterface` class can be found at

    Affiniti\Config\Loader\Loader

The abstract `Loader` class requires two methods to be implemented: `load` and `supports`.  See the [Symfony Config component docs](http://symfony.com/doc/current/components/config/resources.html#resource-loaders) for more information on how to implement these.

### Registing a custom LoaderInterface

Registration is done through the `config.manager` service:

    $app['config.manager']->addLoader(new MyLoader());

Note that much like both config files and definitions, loaders should be added before the `config` service is accessed.

<p />

<div style="text-align:center">
  <a href="definitions.md">&lt; Prev (Definitions)</a> | <a href="caching.md">Next (Caching) &gt;</a>
</div>