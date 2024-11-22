# Larva Interactions

Web interactions use Larva stack.

> Larva = Laravel + Livewire + Tailwind + Alpine

## How to run?

Make sure you use PHP version 8.3 or higher and NodeJS version 20 or higher.

```bash
# First tab terminal
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan storage:link
```

```bash
# Second tab terminal
pnpm i
pnpm run dev
```

## Interactions

- Third-party library
    - Select (Tom Select)
    - Alert (Sweet Alert)
    - Text Area (Trix Editor)
    - Nested Sortable
- Form
- Datatable
- Job Batching

### Job Batching

In order to make Job Batching works, I use queue with Redis and job batching feature in Laravel. The reason has mentioned in [Laravel documentation](https://laravel.com/docs/11.x/queues#introduction).

> While building your web application, you may have some tasks, such as parsing and storing an uploaded CSV file, that take too long to perform during a typical web request. Thankfully, Laravel allows you to easily create queued jobs that may be processed in the background. By moving time intensive tasks to a queue, your application can respond to web requests with blazing speed and provide a better user experience to your customers.

Brief steps:

- You already install Redis in your computer.
- Run `redis-server` in tab terminal.
- Run `php artisan queue:work` to start queue.
