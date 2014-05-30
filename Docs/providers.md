## Usage with Providers

If you are developing a custom Provider and you would like to use the ConfigServiceProvider in your package, a few events have been put in place for this purpose.  We encourage the use of these events to tie the Config provider into your package.

All events which the ConfigServiceProvider produces can be found in the `Affiniti\Config\Event` namespace.

### Listening for Events

Listening for events in the Silex framework is easy using the application dispatcher.  The event logic can be processed in a closure, as follows:

    $app['dispatcher']->addListener('event', function($event) {
        // Handle event logic here. 
    });

### The `ConfigRegisteredEvent`

The `ConfigRegisteredEvent` is fired when the service provider is first registered.  This is to allow other providers to set default parameters based on the `configName` provided to the ConfigServiceProvider.  See the [Usage](usage.md) page for more details on `configName`.

The `ConfigRegisteredEvent` has one method: `getConfigName()`.  This allows the listener to define its own parameters and save the config name for later.  The following code saves the config name, and creates a default option `config.my.option`:

    $app['dispatcher']->addListener(Events::CONFIG_REGISTERED, 
        function(ConfigRegisteredEvent $event) use($app) {
            $this->configName = $event->getConfigName();
            $app[$this->configName . '.my.option'] = false;
        }
    );

### The `ConfigInitEvent`

The `ConfigInitEvent` is fired when after the `config` service is accessed, but before any configuration files are loaded.  This event allows providers to insert their own config files, definitions, loaders, and cache factories into the `config.manager` service.

The `ConfigInitEvent` has one method: `getConfigManager()`.  This allows the listener to use the config manager as it needs.  The following code adds a new loader and definition to the `config.manager` service:

    $app['dispatcher']->addListener(Events::CONFIG_INIT, 
        function(ConfigInitEvent $event) {
            $manager = $event->getConfigManager();
            $manager->addLoader(new MyCustomLoader());
            $manager->addDefinition(new MyDefinition());
        }
    );

**Note**: If the `config` service is never used, this event will not be dispatched. 

### The `ConfigLoadedEvent`

The `ConfigLoadedEvent` is fired directly after the configuration files are loaded.  This event allows providers to execute an action which requires configuration to be loaded.  It has one method: `getConfig()`, which returns the configuration array.

    $app['dispatcher']->addListener(Events::CONFIG_LOADED, 
        function(ConfigLoadedEvent $event) {
            $config = $event->getConfig();
            $myConfig = $config['myConfig'];
    
            // Do something with the config here.
        }
    );

**Note**: If the `config` service is never used, this event will not be dispatched.

<p />

<div style="text-align:center">
  <a href="caching.md">&lt; Prev (Caching)</a> | <a href="testing.md">Next (Unit Testing) &gt;</a>
</div> 