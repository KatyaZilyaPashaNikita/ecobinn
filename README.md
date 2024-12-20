# ECOBIN - Сайт агитации переработки мусора

## Требования

- Docker
- Docker Compose

## Запуск

1. Клонируйте репозиторий:
```bash
git clone https://github.com/KatyaZilyaPashaNikita/ecobin
cd ecobin
```

2. Настройте среду:
```bash
cp .env.example .env
```

3. Запустите контейнеры Docker:
```bash
docker compose up -d --build
```

4. Настройте приложение:
```bash
# Получите ID контейнера app
docker ps

# Зайдите в терминальную среду контейнера
docker exec -it <id> sh

# Внутри контейнера выполните:
php artisan migrate
php artisan storage:link
php artisan db:seed --class=AdminSeeder
php artisan key:generate
```

5. Откройте приложение:
- Откройте Контейнер ecobin-nginx в вашем браузере
- Доступ администратора:
- Электронная почта: `root@root.com`
- Пароль: `toor`

Приложение запускает три основных контейнера:
- `ecobin-app`: сервер приложений PHP
- `ecobin-nginx`: веб-сервер
- `ecobin-db`: база данных PostgreSQL