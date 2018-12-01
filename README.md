# Overview
You'll be able to use model ids or obfuscated model keys interchangeably on your existing routes WITHOUT custom model binding resolution logic.
0. request comes in
0. obfuscated keys are translated to normal ids (on route {params} and request->inputs)
0. standard route model binding takes place

# Composer Installation
0. add the repo to composer.json "repositories": [{"type": "vcs", "url": "https://github.com/fuqu-io/laravel-ids2keys"}]
2. `composer require fuqu-io/laravel-ids2keys`


# Usage Out-of-the-box...
0. run `php artisan ids2keys:setup`
0. Add the trait to your model(s).  `use FuquIo\LaravelIds2Keys\Id2KeyTrait;`
0. Assign the middleware alias 'ids2keys' or 'keys2ids' to any routes you like.  These are exactly the same middlewares, so just choose the one that seems more logical to you.

# Not so advanced config...
In dev, you may find it handy to see both the key and the id, so take a look at the config.

0. run `php artisan vendor:publish --provider="FuquIo\LaravelIds2Keys\ServiceProvider" --tag=config`
0. then take a look at config/fuqu-ids2keys.php

### Under the hood...
* The model trait `use FuquIo\LaravelIds2Keys\Id2KeyTrait;` will create an encoded 'key' attribute for your json.
* The middleware will decode route parameters BEFORE laravel's built in route-model binding.
* Posted inputs will also be taken care of prior to validation, so you can use normal 'exists' and stuff.