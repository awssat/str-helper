# str-helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/str-helper.svg?style=flat-square)](https://packagist.org/packages/awssat/str-helper)
[![StyleCI](https://styleci.io/repos/111329905/shield?branch=master)](https://styleci.io/repos/111329905)
[![Build Status](https://img.shields.io/travis/awssat/str-helper/master.svg?style=flat-square)](https://travis-ci.org/awssat/str-helper)


A powerful, yet simple str helper for Laravel. It gives you the magic of method chaining and it's easier and shorter to be included in views.

Instead of using this in your view: 
```
Illuminate\Support\Str::upper(Illuminate\Support\Str::slug('Hi World'))
``` 
you could just use:
```php
str('Hi World')->slug()->upper()
```

<p align="center">
  <img width="500"" src="https://pbs.twimg.com/media/DPBjIqdWAAEvZcA.png">
</p>




## Install/Use
You can install the package via composer locally in your project folder:

```bash
$ composer require awssat/str-helper
```

After installing it, just start using the helper `str()`: 

## Examples
```bash
str('Hi Hello')->slug()->limit(2)->contains('l');
= false
```

```bash
str('Hi Hello')->slug()->contains('-');
= true
```

```bash 
str('Hi Hello')->slug();
= hi-hello
```


```bash 
str('العيد')->ascii();
= alaayd
```

```bash
str('Hi Hello')->camel()->finish('::')->replaceLast(':', 'Z');
= hiHello:Z
```

In case you want an explicit string value for conditions, use "get":
```bash
if(str('Hi')->finish(' ZY')->lower()->get() == 'hi zy'){ echo 'yes'; }
yes
```

or you could just use it as an alias

```bash
str()->slug('Hi World');
= hi-world
```


## Tests
Simply use:
```bash
$ composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
