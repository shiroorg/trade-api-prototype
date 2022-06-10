### Install
```bash
composer require trade-api-prototype/src
```

### Example
Example using a `class` in work
```php
$Trade = new Trade\Payeer(array(
    'id' => 'XXXXX',
    'key'=> 'XXXXX'
));

$Trade->Account();
```
Configuration example `composer`
```json
 "minimum-stability": "dev",
  "require": {
    "trade-api-prototype/src": "dev-master"
  }
```
