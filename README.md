# Affiniti ConfigServiceProvider
---
**Version**: v0.1

The ConfigServiceProvider, built by Affiniti Development, is a Silex Service Provider which adds support for the Symfony Config Component.  It provides shortcuts to all of the functionality of the Config component - features include:

- Loading and Validating Config Files.
- Multiple Directory Support.
- Config Cache Support.
- Included formats: YAML, INI, and PHP.
- Support for Custom Definitions, Loaders, and Cache Implementations.
- Events allow for use with other Silex service providers.

## Build Status

[![Code Quality](https://scrutinizer-ci.com/g/affinitidev/silex-config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/affinitidev/silex-config/?branch=master)

[![Code Coverage](https://scrutinizer-ci.com/g/affinitidev/silex-config/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/affinitidev/silex-config/?branch=master)

[![Build Status](https://travis-ci.org/affinitidev/silex-config.svg?branch=master)](https://travis-ci.org/affinitidev/silex-config)

## Documentation

Documentation is located [right here](Docs/index.md) in the `Docs` folder.  This includes installation instructions, quick start guide, and advanced features.  The documentation is currently in markdown format.

## License

Distributed under the good old MIT license.  See the complete license in the `LICENSE` file.

## Contributing

*Open for contributions, 24 hours a day, 7 days a week!*

If you would like to contribute, please do!  I ask that you follow these simple rules for an issue or feature request.  Note that if you only want to report an issue or feature request (and not code it), then only step 1 applies. 

### Issues

Often times issues can be small, and may be coded before an issue exists in the tracker.  We ask that you please follow these rules when fixing issues:

1.  Check the issue tracker, and create an issue if one does not exist for the bug.
2.  If you'd like to work on the issue, note on the issue that you are currently coding the fix.  
3.  Code your fix, with unit tests if applicable.
4.  Send a pull request with the commit message `fixes #<issue number>`, replacing `<issue number>` with the issue number to be fixed.
5.  Discussion may take place on the pull request before a merge is approved. 

### Feature Requests

Before a feature request is coded, it should first be discussed on the issue tracker.  This is to prevent wasted time if a feature is not pulled.  Please follow these rules when making feature requests:

1.  Check the issue tracker for the feature, and create an issue if one does not exist for the feature.
2.  After some possible discussion, the issue will be marked as "Approved".  Coding should not start until this point.
3.  If you'd like to work on the issue, note on the issue that you are currently coding the feature.
4.  Code the feature, with unit tests if applicable.
5.  Send a pull request with the commit message `resolves #<issue number>`, replacing `<issue number>` with the feature number to be resolved.
6.  Discussion may take place on the pull request before a merge is approved.

## Project Information

### Maintainer

This package is released under Affiniti Development, which is my vendor "pseudonym".  I am [Brendan Bates](http://www.brendan-bates.com/), the project maintainer.  The pseudonym is simply to make for a prettier `namespace`!

### Website

The project will always be available here on [Github](http://github.com/affinitidev/silex-config).  Currently the repository also serves as the primary documentation website.