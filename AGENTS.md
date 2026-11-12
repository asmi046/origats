# AGENTS.md

Файл для AI-агентов, работающих с этим проектом. Предполагается, что читатель ничего не знает о проекте.

## Обзор проекта

Это веб-приложение на **Laravel 13** (PHP ^8.3) с фронтендом на **Vite + Tailwind CSS v4**. Проект находится на ранней стадии: по сути это стартовый скелет Laravel с одной страницей-заглушкой (`resources/views/welcome.blade.php`), которая пока осталась от шаблона Laravel. Задачи по наполнению сайта оформляются как описания на русском языке в каталоге `promts/` (например, `promts/start.md` описывает главную страницу с фоном `public/img/main_page_b.webp` и логотипом `public/img/logo.svg`). Документация и рабочие описания проекта ведутся на русском языке.

Ключевые конфигурационные файлы:

- `composer.json` — PHP-зависимости и composer-скрипты (`setup`, `dev`, `test`).
- `package.json` — JS-зависимости (vite, tailwindcss, laravel-vite-plugin) и скрипты `dev`/`build`.
- `phpunit.xml` — конфигурация тестов (Pest поверх PHPUnit).
- `.env` — окружение (БД по умолчанию — SQLite, `database/database.sqlite`).
- `vite.config.js` — конфигурация фронтенд-сборки.
- `boost.json`, `.mcp.json` — конфигурация Laravel Boost (MCP-инструменты для агента).

## Технологический стек

- **Бэкенд:** PHP ^8.3, Laravel ^13.17, laravel/tinker.
- **Фронтенд:** Vite ^8, Tailwind CSS ^4 (через `@tailwindcss/vite`), laravel-vite-plugin ^3. JS-фреймворков (Vue/React) нет — только Blade-шаблоны.
- **База данных:** SQLite (`database/database.sqlite`), миграции в `database/migrations` (users, cache, jobs — стандартный набор Laravel).
- **Тестирование:** Pest ^5 (`pestphp/pest`, `pestphp/pest-plugin-laravel`), тесты в `tests/Unit` и `tests/Feature`.
- **Форматирование PHP:** Laravel Pint (`vendor/bin/pint`).
- **Dev-зависимости:** laravel/boost (MCP-инструменты), laravel/pail (логи), faker, mockery, collision.

## Команды сборки и запуска

```sh
composer run setup   # полная установка: composer install, .env, key:generate, migrate, npm install, npm run build
composer run dev     # запуск dev-окружения (php artisan dev: сервер + vite + очередь + логи одновременно)
npm run dev          # только vite dev-сервер
npm run build        # продакшн-сборка фронтенда (public/build)
php artisan serve    # dev-сервер без остальных процессов
```

Если изменения фронтенда не видны в браузере или возникает ошибка «Unable to locate file in Vite manifest» — выполнить `npm run build` (или запустить `npm run dev`).

## Тестирование

```sh
composer test                    # config:clear + php artisan test
php artisan test                 # весь набор тестов
php artisan test --compact tests/Feature/SomeTest.php   # конкретный файл
php artisan test --compact --filter=testName            # конкретный тест
vendor/bin/pest                  # прямой запуск Pest (те же аргументы)
```

Тестовое окружение: SQLite `:memory:`, драйверы cache/session — `array`, очередь — `sync`. Тесты пишутся на **Pest**: создавать через `php artisan make:test --pest {Name}` (без указания директории; `--unit` для юнит-тестов). Большинство тестов — feature-тесты. Для моделей использовать фабрики (`database/factories`). Не удалять существующие тесты без одобрения.

## Организация кода

Стандартная структура Laravel:

- `app/Http/Controllers` — контроллеры (пока пусто).
- `app/Models` — Eloquent-модели (только `User.php`).
- `app/Providers` — сервис-провайдеры.
- `routes/web.php` — веб-маршруты (пока один маршрут `/` → `welcome`). `routes/console.php` — команды консоли.
- `resources/views` — Blade-шаблоны.
- `resources/css/app.css`, `resources/js/app.js` — точки входа фронтенда, подключаемые через `@vite` в Blade.
- `public/img`, `public/tmp_data` — статические изображения и данные (например, `main_page_b.webp`, `logo.svg`).
- `database/migrations`, `database/factories`, `database/seeders` — БД-слой.
- `config/` — конфигурация Laravel (app, auth, database, cache, queue и т.д.).

Новые файлы (модели, контроллеры, миграции, тесты) создавать командами `php artisan make:*` с флагом `--no-interaction`. При создании модели сразу делать фабрику и сидер. Не создавать новые корневые каталоги и не менять зависимости без одобрения пользователя.

## Стиль кода

- PHP: всегда использовать фигурные скобки в управляющих конструкциях; constructor property promotion (PHP 8); явные типы параметров и возвращаемых значений; PHPDoc вместо инлайн-комментариев; ключи enum в TitleCase.
- После изменения PHP-файлов запустить `vendor/bin/pint --dirty --format agent` для приведения кода к стилю проекта.
- Имена переменных и методов — описательные (`isRegisteredForDiscounts`, а не `discount()`).
- Перед написанием нового компонента проверить, нет ли уже существующего для переиспользования.
- Перед изменениями, зависящими от API пакетов Laravel-экосистемы, использовать инструмент `search-docs` Laravel Boost; версии пакетов проверять через `composer show --direct`.

## Безопасность

- Никогда не коммитить `.env` — секреты только там; `.env.example` — шаблон без реальных ключей.
- Не читать, не копировать и не передавать содержимое `.env` и секретных файлов.
- Валидация пользовательского ввода — через Form Request / валидатор Laravel; вывод в Blade — с экранированием (`{{ }}`), сырый вывод (`{!! !!}`) — только для доверенного контента.
- Миграции запускать осознанно: `php artisan migrate` (в `composer setup` используется `--force`).

## Особенности проекта

- Задания на разработку страниц/функциональности приходят в виде текстовых описаний на русском в `promts/*.md` — сверяться с ними при работе над соответствующей страницей.
- В проекте установлен Laravel Boost: предпочитать его MCP-инструменты (`database-query`, `database-schema`, `browser-logs`, `search-docs`) ручным обходным путям.
- Подробные правила Laravel Boost также продублированы в `CLAUDE.md`.
