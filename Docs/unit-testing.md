## Unit Testing

Unit testing is an important part of the development process.  If you plan on contributing to the project, then knowing how to run the test suite is important.  Code coverage should be near 100% unit tested.

### Running the Test Suite

The test suite used for unit testing by the ConfigServiceProvider is [PHPUnit](http://phpunit.de/).  It is included in the `composer.json` require-dev dependencies - if running `composer.phar update`, it will automatically be included.

The test suite can be run from the base directory, where the `phpunit.xml` configuration file resides.  A shortcut file `phpunit.php` in the root directory invokes the PHPUnit file if needed:

    php phpunit.php

This will run all tests.

### Tests for New Issues

Tests for new issues can be added one of two ways: 

- Added to existing tests to prove failure. 
- Put in the `Tests/Issues/<issue #>`, where `<issue #>` is replaced with the number of the issue on the Issue Tracker.  Comment in test should describe the issue at hand.

In both cases, the test should fail before the fix is applied, and pass after.

### Tests for New Features

Tests for new features should either be added to existing tests.  If a new class was created, this new class should be fully tested.