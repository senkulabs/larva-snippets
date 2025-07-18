# Larva Snippets

Reusable pieces of Larva stack.

> Larva = Laravel + Livewire + Tailwind + Alpine

## How to run?

Make sure you use PHP version 8.3 or higher and NodeJS version 20 or higher.

```sh
cp .env.example .env
composer install && pnpm install
php artisan key:generate
php artisan migrate
php artisan storage:link
composer run dev
```

## Snippets

- Form
- Reset Password
- Alert (Sweet Alert)
- Trix Editor
- Nested Sortable
- Select (Tom Select)    
- Datatable
- Job Batching

### Job Batching

In order to make Job Batching works, I use queue with Redis and job batching feature in Laravel. The reason has mentioned in [Laravel documentation](https://laravel.com/docs/11.x/queues#introduction).

> While building your web application, you may have some tasks, such as parsing and storing an uploaded CSV file, that take too long to perform during a typical web request. Thankfully, Laravel allows you to easily create queued jobs that may be processed in the background. By moving time intensive tasks to a queue, your application can respond to web requests with blazing speed and provide a better user experience to your customers.

Brief steps:

- You must install Redis in your computer.
- Run `redis-server` in tab terminal.

## Torchlight Token

