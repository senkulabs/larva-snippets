# Larva Interactions

Web interactions use Larva stack.

> Larva = Laravel + Livewire + AlpineJS + TailwindCSS

## Interactions

- Button
- Select with third-party (Tom Select)
- Alert with third-party (Sweet Alert)
- Nested Sortable
- Form
- Upload CSV file
- Datatable (soon)
- Reset Password (soon)

### Upload CSV File

To run this case with Docker container, I use docker image from serversideup/docker-php. In this project, I try to test Laravel Job Batching (e.g. Process CSV File). The ServerSideUp docs recommend to create 2 container in order to use queue worker. In order to use queue worker, I need to create 2 containers. First container is web app, the second container is queue worker. The 2 container use the same Docker image.

> Note: If you use queue worker in separate container, I would recommend to use QUEUE_CONNECTION such as database (MySQL) or redis (Redis). SQLite doesn't work because it doesn't share connection between 2 containers.

Steps:

1. Copy example .env file and update the value of necessary key.

```bash
cp .env.example .env
```

Usually, I update values on keys like:

```bash
DB_HOST=???
DB_DATABASE=???
DB_USERNAME=???
DB_PASSWORD=???

QUEUE_CONNECTION=???

REDIS_HOST=???
REDIS_PASSWORD=???
REDIS_PORT=6379
# I'm using predis because it is simple to install instead of phpredis.
# I understand that performance of phpredis is better than predis.
REDIS_CLIENT=predis
```

2. Run necessary command below.

```bash
composer install
php artisan key:generate
# Copy csv file to storage/app folder because I need to use this as example.
cp csvfile/* storage/app
```

3. Build docker image with command below.

```bash
# Build a Docker image
docker build --no-cache -t kresnasatya/larva-interactions .
```

4. Run docker compose with command below.

```
docker compose -f dev.docker-compose.yml up -d
```

5. Open [http://localhost:8080](http://localhost:8080) then click **Process CSV File** in Laravel Features section.