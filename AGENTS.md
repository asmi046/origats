<!-- Файл для AI-агентов, работающих с этим проектом. Предполагается, что читатель ничего не знает о проекте. -->

## Обзор проекта

Это веб-приложение на **Laravel 13** (PHP ^8.3) с фронтендом на **Vite + Tailwind CSS v4**. Проект — сайт верификации брендовой одежды (лицензионного мерча артистов) «ТРУ СТАРЗ» (домен `origa-ts.top`). Сейчас реализована одна страница — главная (`resources/views/welcome.blade.php`): чёрный фон, полноэкранный блок с фоном `public/img/main_page_b.webp` (на мобильных — `main_page_b_mob.webp`), логотип `public/img/logo.svg` с каскадом анимаций (фон → лого → надпись), надпись «Ваша продукция оригинальная, при наличии голограммы». У страницы настроены SEO-мета, Open Graph и набор favicon/иконок (в `public/img`). Документация и задания ведутся на русском языке.

Задания на разработку страниц/функциональности приходят в виде текстовых описаний на русском в каталоге `promts/` (например, `promts/start.md` описывал главную страницу). Сверяться с ними при работе над соответствующей страницей.

Ключевые конфигурационные файлы:

- `composer.json` — PHP-зависимости и composer-скрипты (`setup`, `dev`, `test`).
- `package.json` — JS-зависимости (vite, tailwindcss, laravel-vite-plugin) и скрипты `dev`/`build`, а также скрипты деплоя на прод-сервер (см. ниже).
- `phpunit.xml` — конфигурация тестов (Pest поверх PHPUnit).
- `.env` — окружение (БД по умолчанию — SQLite, `database/database.sqlite`).
- `vite.config.js` — конфигурация фронтенд-сборки (включая загрузку шрифта Instrument Sans через `@fontsource`-плагин `bunny`).
- `boost.json`, `.mcp.json` — конфигурация Laravel Boost (MCP-инструменты для агента).

## Технологический стек

- **Бэкенд:** PHP ^8.3, Laravel ^13.17, laravel/tinker.
- **Фронтенд:** Vite ^8, Tailwind CSS ^4 (через `@tailwindcss/vite`), laravel-vite-plugin ^3. JS-фреймворков (Vue/React) нет — только Blade-шаблоны. Основной шрифт — Instrument Sans (подключается через `vite.config.js` и `@theme` в `resources/css/app.css`).
- **База данных:** SQLite (`database/database.sqlite`), миграции в `database/migrations` (users, cache, jobs — стандартный набор Laravel).
- **Тестирование:** Pest ^5 (`pestphp/pest`, `pestphp/pest-plugin-laravel`), тесты в `tests/Unit` и `tests/Feature`.
- **Форматирование PHP:** Laravel Pint (`vendor/bin/pint`).
- **Dev-зависимости:** laravel/boost (MCP-инструменты), laravel/pail (логи), faker, mockery, collision, laravel/pao.

## Команды сборки и запуска

```sh
composer run setup   # полная установка: composer install, .env, key:generate, migrate --force, npm install, npm run build
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

## Деплой

Деплой — вручную через ssh-скрипты из `package.json` на прод-сервер `user@129.101.94.205`, каталог `web/origa-ts.top/public_html`:

```sh
npm run deploy_m        # полный деплой фронтенда: vite build + отправка public/build (scp) + git pull + optimize_all + chmod
npm run send_vite_build # только отправка сборки (scp public/build)
npm run pull_rep        # git pull на сервере
npm run migrate_rep     # миграции на сервере (php8.4 artisan migrate --force)
npm run optimize_all    # cache:clear + view:cache + route:cache + config:cache
```

Сервер использует PHP 8.4 (`php8.4 artisan ...`, composer через `composer.phar`). Сборка фронтенда делается локально и отправляется на сервер через `scp`, а не собирается на сервере. Остальные команды (`stash`, `reset_rep`, `cache_*`, `seed_rep`, `storage_link` и т.д.) — типовые обслуживающие действия на том же сервере.

## Организация кода

Стандартная структура Laravel:

- `app/Http/Controllers` — контроллеры (пока пусто).
- `app/Models` — Eloquent-модели (только `User.php`).
- `app/Providers` — сервис-провайдеры.
- `routes/web.php` — веб-маршруты (один маршрут `/` → `welcome`). `routes/console.php` — команды консоли.
- `resources/views` — Blade-шаблоны (`welcome.blade.php` — главная страница).
- `resources/css/app.css`, `resources/js/app.js` — точки входа фронтенда, подключаемые через `@vite` в Blade.
- `public/img` — статические изображения (логотипы, фоны, favicon, og-image); `public/tmp_data` — временные исходники изображений.
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
- Скрипты деплоя из `package.json` подключаются к прод-серверу по ssh — запускать их только осознанно (это действия на боевом сервере, часть из них деструктивна: `reset_rep`, `db_update_total`, `clean_rep`).
- Валидация пользовательского ввода — через Form Request / валидатор Laravel; вывод в Blade — с экранированием (`{{ }}`), сырой вывод (`{!! !!}`) — только для доверенного контента.
- Миграции запускать осознанно: `php artisan migrate` (в `composer setup` используется `--force`).

## Особенности проекта

- Задания на разработку страниц/функциональности приходят в виде текстовых описаний на русском в `promts/*.md` — сверяться с ними при работе над соответствующей страницей.
- В проекте установлен Laravel Boost: предпочитать его MCP-инструменты (`database-query`, `database-schema`, `browser-logs`, `search-docs`) ручным обходным путям.
- Главная страница содержит каскад анимаций (фон → лого → надпись) с задержкой старта ~1.5 с, чтобы фон успевал прогрузиться на слабом интернете; при правках страницы это поведение сохранять.
- Подробные правила Laravel Boost также продублированы в `CLAUDE.md`.
