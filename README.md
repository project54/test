## Установка и настройка

### Установка Composer
```bash
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
```

### Установка зависимостей
```bash
    composer install
```

### Настройка подключения к базе данных
Настроить конфиг ``config/db.php``

### Накатить миграцию
```bash
    ./app migrate
```

## Использование
```bash
    ./app balance/transfer idUserFrom idUserTo sum
```