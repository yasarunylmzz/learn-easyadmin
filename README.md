# Learn EasyAdmin

Symfony 8.0 ve EasyAdmin 5.0 ile blog admin paneli ogrenme projesi.

## Tech Stack

- PHP 8.4+
- Symfony 8.0
- EasyAdmin 5.0
- PostgreSQL (Doctrine ORM)
- Tailwind CSS
- AssetMapper + Stimulus + Turbo + Chart.js (UX)

## Kurulum

```bash
# Bagimliliklar
composer install

# Veritabani olustur
php bin/console doctrine:database:create

# Migration calistir
php bin/console doctrine:migrations:migrate

# Test verileri yukle
php bin/console doctrine:fixtures:load

# Tailwind build
php bin/console tailwind:build --watch

# Sunucuyu baslat
symfony server:start
```

## Veritabanini Sifirla (Tek Komut)

```bash
php bin/console doctrine:database:drop --force --if-exists && php bin/console doctrine:database:create && php bin/console make:migration && php bin/console doctrine:migrations:migrate --no-interaction && php bin/console doctrine:fixtures:load --no-interaction
```

## Entity Yapisi

- **User** - UUID, email, password (hashed), roles (ROLE_ADMIN, ROLE_USER)
- **BlogPost** - title, description, slug, createdAt (auto), author (User), tags (Tag)
- **Tag** - name

## Iliskiler

- User -> BlogPost: OneToMany
- BlogPost -> Tag: ManyToMany

## Sayfalar

- `/` - Ana sayfa
- `/login` - Giris sayfasi
- `/admin` - Admin paneli (ROLE_USER gerektirir)
