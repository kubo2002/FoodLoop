# FoodLoop – Laravel Project

FoodLoop je webová aplikácia, ktorá spája donorov potravín s recipientmi.  
Donori môžu vytvárať ponuky prebytočných potravín a recipienti si ich môžu vyzdvihnúť.  
Projekt bol vytvorený ako semestrálna práca pre predmet **VAII**.

---
## Funkcionalita

### Autentifikácia
- Registrácia a prihlásenie používateľov (Laravel Auth)
- Podpora dvoch rolí: **donor** a **recipient**
- Úprava profilu + nahrávanie profilovej fotky

### Ponuky (CRUD)
- **Create** – donor pridáva ponuky vrátane obrázka  
- **Read** – zobrazenie ponúk podľa kategórie  
- **Update** – úprava ponuky  
- **Delete** – mazanie ponuky **cez AJAX** bez reloadu

### Kategórie
- Dynamické načítanie ponúk cez AJAX (fetch API)
- Interaktívne zvýrazňovanie vybratej kategórie

### Viacjazyčnosť
- Celá aplikácia podporuje **SK/EN**
- Preklady v resources/lang

### Validácia
- Klientská validácia (JS – login, register)
- Serverová validácia (Laravel Requests)

### UI + Responzívny dizajn
- Bootstrap 5
- Hamburger menu
- Vlastné CSS pravidlá

---

## Použité technológie

- **Laravel 12.x**
- **PHP 8.3**
- **MySQL (Docker)**
- **Bootstrap 5**
- **JavaScript (fetch API, AJAX, DOM manipulation)**
- **Eloquent ORM**
- **Blade Templates**

---

## Projektová štruktúra
- `docker-compose.yml` – Docker service definitions
- `Dockerfile` – PHP 8.3 FPM configuration
- `app/` – application source code
- `routes/` – route definitions
- `resources/` – Blade templates & frontend assets
- `database/` – migrations and seeders

## Požiadavky

- Docker & Docker Compose  

---

## Spustenie projektu (Docker)

Projekt beží v Docker Compose.  

### 1. Klonovanie projektu
```bash
git clone https://github.com/username/FoodLoop.git
cd FoodLoop
```

### 2. Spustenie Docker kontajnerov
```bash
docker-compose up -d
```

### 3. Inštalácia composer závislostí
```bash
docker exec -it foodloop_app composer install
```

### 4. Vytvorenie .env súboru
```bash
cp .env.example .env
```

### 5. Generovanie aplikáčneho kľúča
```bash
docker exec -it foodloop_app php artisan key:generate
```

### 6. Migrácie databázy
```bash
docker exec -it foodloop_app php artisan migrate
```

### 7. Spustenie projektu
```bash
http://localhost:8000
```
