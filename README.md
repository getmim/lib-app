# lib-app

Adalah module yang menyediakan service `app` pada aplikasi untuk memenej
aplikasi yang sedang melakukan request. Module ini membutuhkan module
user sebagai penyedia authorizer.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-app
```

## Pengunaan

Module ini membuat satu service dengan nama app yang bisa di panggil dari
aplikasi dengan perintah `$this->app->{prop|method}`.

```php
$this->app->isAuthorized();
$this->app->id;
$this->app->revoke();
```

Method yang disediakan adalah:

### isAuthorized(): bool
### revoke(): void
### hasScope(string $scope): bool

## Authorizer

Authorizer module ini menggunakan authorizer user, dengan catatan authorizer
yang mungkin menggunakan aplikasi juga harus mengimplementasikan interface
`LibApp\\Iface\\Authorizer`. Dengan begitu authorizer tersebut harus memiliki
tambahan method:

### hasScope(string $scope): bool

Selain itu, perintah `getSession` pada authorizer harus juga mengembalikan properti
`app` yang berisi aplikasi id yang sedang digunakan.

```php
$session = (object)[
    'type' => 'cookie',
    'expires' => time() + 60,
    'token' => 'random-string',
    'app' => 1 | NULL
];
```