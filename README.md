# str-helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/str-helper.svg?style=flat-square)](https://packagist.org/packages/awssat/str-helper)
[![StyleCI](https://styleci.io/repos/111329905/shield?branch=master)](https://styleci.io/repos/111329905)
[![Build Status](https://img.shields.io/travis/awssat/str-helper/master.svg?style=flat-square)](https://travis-ci.org/awssat/str-helper)


⚡️  A flexible, simple & yet powerful string manipulation helper for PHP. It gives you the magic of method chaining and it's easier and shorter to be included in views. It Supports most of [PHP built-in strings functions](http://php.net/manual/en/book.strings.php) (and any custom functions).


```php
str('Hi World')->strReplace(' ', '+')->strtolower()
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
str('Hi Hello')->strReplace(' ', '-');
>> hi-hello
```

if used with Laravel, you could use its string helpers:
```bash
str('Hi Hello')->slug()->limit(2)->contains('l');
>> false
```

```bash
str('Hi Hello')->camel()->finish('::')->replaceLast(':', 'Z');
>> hiHello:Z
```

In case you want an explicit string value for conditions, use "get":
```bash
if(str('Hi')->strtolower->get() == 'hi'){ echo 'yes'; }
>> yes
```


There is a "tap" method:
```bash
str('LINK.COM')->tap(function($v){ exit($v); })->lower()
>> LINK.COM
```

for callbacks use "do" method:
```bash
str('<a>link.com</a>')->do(function($string){ 
        return strip_tags($string); 
})
>> link.com
```
or: 
```bash
str('<a>link.com</a>')->do(function(){   
        $this->stripTags();
})
>> link.com/
```

If used with Laravel, Any resulted array will be converted to a collection for convenience 
```bash
str('hellow|world')->explode('|')
                ->each(function($item){
                         echo '[' . $item . ']';
                });

>> [hello][world]
```


You can also use conditions, if(..), else(), endif()
```php
str('<html>hi</html>')
            ->ifStrpos('hi')
            ->strtoupper();
>> <HTML>HI</HTML>       
```


if can take an anonymous function
```php
str('<html>hi</html>')
            ->if(function(){
                    return $this->contains('hi');
            })
            ->strtoupper();
>> <HTML>HI</HTML>       
```



## Tests
Simply use:
```bash
$ composer test
```
## Credits
- [Abdulrahman M.](https://github.com/abdumu)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
