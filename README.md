# M4nu MultiDomainBundle

[![Build Status](https://travis-ci.org/M4nu/MultiDomainBundle.svg)](https://travis-ci.org/M4nu/MultiDomainBundle)

This bundle is licensed under the [MIT License](LICENSE).

The MultiDomainBundle provides multi-domain capabilities to
Symfony Cmf [RoutingBundle](https://github.com/symfony-cmf/RoutingBundle).

## Requirements

* Symfony ~2.3
* SymfonyCmfRoutingBundle ~1.2
* See also the `require` section of [composer.json](composer.json)

## Installation

### Get the bundle

Add the following lines in your composer.json:

```
{
    "require": {
        // ...
        "m4nu/multi-domain-bundle": "dev-master",
    }
}
```

### Initialize the bundle

To start using the bundle, register the bundle in your application's kernel class:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new M4nu\MultiDomainBundle\M4nuMultiDomainBundle(),
    );
)
```

### Configuration

You must define at least 1 domain, for example :

``` yaml
# app/config/config.yml
m4nu_multi_domain:
    domains:
        en: www.example.org
        fr: fr.example.org
