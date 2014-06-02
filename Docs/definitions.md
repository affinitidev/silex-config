## Validation & Definitions

It is often desirable to validate configuration files against a schema, to make sure they are formatted properly.  This is possible in the ConfigServiceProvider using **Definitions**.  Definitions are classes which define the way a config file is processed.

### Creating a Definition

A definition is an extended version of the Symfony Config Component `ConfigurationInterface` class.  A definition must implement the definition interface:

    Affiniti\Config\Definition\DefinitionInterface

This consists of two methods

- `getConfigTreeBuilder()`: This method is used to build a Symfony `TreeBuilder` object, which contains the definition and validation structure.   
- `getType()`: This method is used to match a config file to a given definition type.

Most documentation regarding the Symfony `TreeBuilder` and how to use it can be found on the [Symfony Config documentation](http://symfony.com/doc/current/components/config/definition.html#defining-a-hierarchy-of-configuration-values-using-the-treebuilder).  Use this guide to implement the `getConfigTreeBuilder` method for schema validation.

### Adding Definitions

Adding your definitions are as simple as using the `config.manager` service:

    $app['config.manager']->addDefinition(new MyDefinition());

### Loading a File with a Definition

To load a configuration file with a definition, the second `type` parameter of the added configuration must match a definition type registered with the provider.

    $app['config.manager']->addFile('database.yml', 'database');

In the above example, the `database.yml` will be validated by the definition which has the type `database`.

### Reading Validated Configuration Values

When loading configurations with a definition, they are referenced the same way they are without the definition.  The `type` provided when the file was added is used to index in the `config` service:

    $databaseConfig = $app['config']['database'];

If two files of the same type are defined, they will be merged.  However, this merge behavior can be defined by the definition.  

#### Invalid Configurations

When the configuration is processed, it may be invalid.  The `Affiniti\Config\Exception\ValidationError` exception will be thrown if an invalid configuration is processed.  The message contains details regarding the invalid configuration.

It may be useful to wrap your first access to the config container in a `try/catch` block to catch a possible invalid configuration.

### The `Definition` Base Class

An abstract definition class is available to be used: `Affiniti\Config\Definition\Definition`.  This class provides a shortcut to the `getType()` method by using the classname.  It removes 'Definition' from the classname, and lowercases the first character.  For example, using the example class:

    class DatabaseDefinition extends Definition

The result of `getType()` would be the type `database`, and you could import configuration files using this type.

### Definition Example

The following example represents a definition for a database configuration:

    // DatabaseDefinition.php

    use Affiniti\Config\Definition\DefinitionInterface;
    use Symfony\Component\Config\Definition\Builder\TreeBuilder;

    class DatabaseDefinition implements DefinitionInterface
    {
        public function getConfigTreeBuilder()
        {
	        $treeBuilder = new TreeBuilder();
	        $rootNode = $treeBuilder->root($this->getName());
	        
	        $rootNode->children()
	            ->arrayNode('connection')
	                ->children()
	                    ->enumNode('driver')
	                        ->values([
	                            'pdo_mysql', 'pdo_sqlite', 'pdo_pgsql', 'pdo_oci',
	                            'oci8', 'ibm_db2', 'pdo_ibm', 'pdo_sqlsrv'
	                        ])
	                        ->isRequired()
					    	->end()
	                    ->scalarNode('dbname')->end()
	                    ->scalarNode('host')->end()
	                    ->scalarNode('user')->end()
	                    ->scalarNode('password')->end()
	                    ->scalarNode('charset')->end()
	                    ->scalarNode('path')->end()
	                    ->integerNode('port')->end()
	                ->end()
	            ->end();
        }

        public function getType()
        {
            return 'database';
        } 
    }

Here is a valid YAML file:

    # database.yml
    connection:
        driver: pdo_mysql
        dbname: test
        host: localhost
        user: root
        password: ~

The definition and file can be loaded using the `config.manager` service:

    $manager = $app['config.manager'];
    $manager->addDefinition(new DatabaseDefinition());
    $manager->addFile('database.yml', 'database');

The configuration can then be accessed using the `config` service:

    $databaseConfig = $app['config']['database'];


<p />

<div style="text-align:center">
  <a href="getting-started.md">&lt; Prev (Getting Started)</a> | <a href="loaders.md">Next (Loaders) &gt;</a>
</div>