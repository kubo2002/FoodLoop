# FoodLoop

FoodLoop je webová aplikácia, ktorá spája donorov potravín s recipientmi. Donori môžu vytvárať ponuky prebytočných potravín a recipienti si ich môžu rezervovať a vyzdvihnúť. Projekt vznikol ako semestrálna práca pre predmet VAII.

## Použité technológie
- Laravel 12.x
- PHP 8.3
- MySQL 8
- Blade templating
- Eloquent ORM
- Bootstrap 5
- JavaScript (fetch API, AJAX)
- Docker & Docker Compose (voliteľné)

## Požiadavky na systém
- PHP 8.3+
- Composer 2.x
- MySQL 8.x (alebo Docker Desktop, ak spúšťate cez Docker)
- Node.js 18+ a npm (ak budete buildovať frontend cez Vite)

## Inštalácia (bez Dockeru)

1. Klonovanie repozitára
```bash
git clone <URL vášho repozitára>
cd FoodLoop
```

2. Inštalácia závislostí
```bash
composer install
npm install
```

3. Konfigurácia prostredia
```bash
cp .env.example .env
php artisan key:generate
```

4. Nastavenie databázy (.env)
Upravte v `.env` tieto hodnoty podľa vašej DB:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodloop
DB_USERNAME=root
DB_PASSWORD=secret
```

5. Migrácie (a seedery, ak existujú)
```bash
php artisan migrate 
```

6. Build frontend assetov (ak používate Vite)
```bash
npm run build
```

7. Spustenie lokálneho servera
```bash
php artisan serve
# Aplikácia beží na http://127.0.0.1:8000
```

## Inštalácia (Docker)

1. Klonovanie repozitára
```bash
git clone <URL vášho repozitára>
cd FoodLoop
```

2. Spustenie kontajnerov
```bash
docker-compose up -d
```

3. Inštalácia composer závislostí (v kontajneri)
```bash
docker exec -it foodloop_app composer install
```

4. Konfigurácia prostredia
```bash
cp .env.example .env
docker exec -it foodloop_app php artisan key:generate
```

5. Migrácie (a seedery)
```bash
docker exec -it foodloop_app php artisan migrate
```

6. Build frontend assetov 
```bash
npm install
npm run build
```

7. Prístup do aplikácie
Otvoríte v prehliadači: `http://localhost:8000`

## Prihlasovacie údaje
- Nie sú poskytnuté predvytvorené (seednuté) účty v tomto README.
- Ak projekt obsahuje seedery s admin účtom, doplňte sem:
  - e‑mail: `admin@example.com`
  - heslo: `secret`

## Stručný popis funkcionalít
- Registrácia a prihlásenie používateľov (role: donor, recipient)
- Profil používateľa (úprava údajov, nahrávanie/mazanie profilovej fotky)
- Ponuky (CRUD): vytváranie, zobrazenie, úprava, mazanie (AJAX)
- Kategórie: filtrovanie ponúk podľa kategórie (AJAX „byCategory“)
- Rezervácie: vlastný zoznam rezervácií (pridanie/úprava/storno)
- Viacjazyčnosť (SK/EN)

## Užitočné príkazy
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
