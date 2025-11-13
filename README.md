# Laravel + Docker Application

This project is a Laravel application running in Docker with PHP 8.3, MySQL 8, and Node 22 (Vite).

## Notes
- The README will be expanded as the project grows.
## Project Structure
- `docker-compose.yml` – Docker service definitions
- `Dockerfile` – PHP 8.3 FPM configuration
- `app/` – application source code
- `routes/` – route definitions
- `resources/` – Blade templates & frontend assets
- `database/` – migrations and seeders

## Requirements

- Docker & Docker Compose  
- Git  
- PHPStorm (recommended)

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/<your-username>/<repo>.git
cd <repo>
```

### 2. Create an `.env` file
Copy the example file:
```bash
cp .env.example .env
```
Update the database configuration to match Docker:
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=foodloop
DB_USERNAME=root
DB_PASSWORD=root
```
### 3. Start Docker containers
```bash
docker compose up -d
```
### 4. Install Composer dependencies
```bash
docker exec -it foodloop_app composer install
```
### 5. Generate application key
```bash
docker exec -it foodloop_app php artisan key:generate
```
### 6. Run database migrations
```bash
docker exec -it foodloop_app php artisan migrate
```
### 7. Start the Laravel development server
```bash
docker exec -it foodloop_app php artisan serve --host=0.0.0.0 --port=8000
```
Application is now available at:
```bash
http://localhost:8000
```

## Frontend (Vite)
### Install NPM dependencies
```bash
docker exec -it laravel_npm npm install
```
### Start Vite dev server
```bash
docker exec -it laravel_npm npm run dev
```
## MySQL Access
You can connect to the MySQL container using any database client.
```bash
Connection details:
    - Host: 127.0.0.1
    - Port: 3306
    - Database: foodloop
    - User: root
    - Password: root
```

