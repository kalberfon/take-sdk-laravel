## ✨ Feature

- **Easy to send notifications via whatsapp.** 

## Installation guide

 - The recommended way to install is through Composer:
 ```
    composer require kalberfon/take-sdk-laravel
 ```
  - Configure **config/service.php**, adding this:

  ```
...
    'whatsapp' => [
        'key' => env('TAKE_ACCESS_KEY'),
        'base_url' => env('TAKE_BASE_URI', 'https://http.msging.net'),
        'namespace' => env('TAKE_NAMESPACE'),
    ],
...
  ```

 - Edit **config/app.php**, add line in providers section: 
```
    'providers' => [
    ...
    \Kalberfon\TakeSdkLaravel\Provider::class,
    ...
```

## :wrench: Supported Versions

Versions will be supported for a limited amount of time.

| Version | Laravel Version | Php Version  |  
|---- |----|----|  
| v1.0.* | >= 5.8 | <=7.1 |
