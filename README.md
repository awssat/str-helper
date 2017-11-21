# str-helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/str-helper.svg?style=flat-square)](https://packagist.org/packages/awssat/str-helper)
[![StyleCI](https://styleci.io/repos/111329905/shield?branch=master)](https://styleci.io/repos/111329905)
[![Build Status](https://img.shields.io/travis/awssat/str-helper/master.svg?style=flat-square)](https://travis-ci.org/awssat/str-helper)


⚡️  A flexible, simple & yet powerful string manipulation helper for Laravel. It gives you the magic of method chaining and it's easier and shorter to be included in views.

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
>> hiHello:Z
```

In case you want an explicit string value for conditions, use "get":
```bash
if(str('Hi')->finish(' ZY')->lower()->get() == 'hi zy'){ echo 'yes'; }
>> yes
```

You can plug php built in functions too
```bash
str('<a>LINK.COM</a>')->finish('/')->stripTags()->lower()
>> link.com/
```
```bash
str('<a>LINK.COM</a>')->finish('!')->strReplace('<a>', '<a href="http://example.com">')->lower()
>> <a href="http://example.com">link.com</a>!
```

There is a "tap" method:
```bash
str('LINK.COM')->finish('/')->tap(function($v){ dd($v); })->lower()
>> LINK.COM/
```

for callbacks use "do" method:
```bash
str('<a>LINK.COM</a>')->finish('/')->do(function($v){ return strip_tags($v); })->lower()
>> link.com/
```

You can also use conditions, if(..), else(), endif() 
```php
str('<html>hi</html>')
            ->ifStrReplace('hi', 'welcome')
            ->upper();
>> <HTML>WELCOME</HTML>       
```

```php
str('<html>HOWDY</html>')
            ->ifStrReplace('hi', 'welcome')
                ->upper()
            ->endif()
            ->stripTags()
            ->lower();
            
>> howdy
```


Or you could just use str() it as a short alias for Illuminate/Support/Str class if you pass nothing to it:
```bash
str()->slug('Hi World');
>> hi-world
```


### Full example with collection:
```php
$names = collect([
            '<a href="url" rel="nofollow">page1</a>',
            '<a href="url">page2</a>',
            '<a href="url">page3</a>',
            '<a href="url">page4 : {name}</a>',
        ]);

$names = $names->map(function ($name) {
    return str($name)
            ->ifContains('nofollow')->StrReplace('page1', 'nofollow PAGE')->lower()
            ->else()->stripTags()->pregReplace('!{name}!', 'articles')
            ->endif()
            ->finish('!')
            ->get();
});
```


## Tests
Simply use:
```bash
$ composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
