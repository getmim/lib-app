# lib-app

Adalah module yang menyediakan service `app` pada aplikasi untuk memenej
aplikasi yang sedang melakukan request. Module ini membutuhkan module
user sebagai penyedia authorizer.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-app
```

## Konfigurasi

Tambahkan konfigurasi seperti di bawah untuk menentukan service apa saja yang
akan digunakan untuk mengambil informasi authorizer:

```php
return [
    'libApp' => [
        'authorizer' => [
            '/module/' => '/service/',
            'lib-user' => 'user',
            'profile-auth' => 'profile'
        ]
    ]
];
```

Masing-masing authorizer harus memiliki method `getAuthorizer` yang akan
mengembalikan class yang mengimplementasikan interface `LibApp\\Iface\\Authorizer`

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

### getAppId(): ?int