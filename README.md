<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Laravel Task Schedule
This is the task schedule for IHRS, it will be run every day at 00:01, to update employee data such as resignations, leave, etc.

## How I create this project
1. Create laravel project (i use laravel v.9):
    ```bash
    composer create-project laravel/laravel="9.*" schedule_ihrs
    ```
2. Navigate into the project directory:
    ```bash
    cd schedule_ihrs
    ```
3. Install PHP dependencies laravel-log-viewer:
    ```bash
    composer require rap2hpoutre/laravel-log-viewer:2.2.0
    ```
4. Publish vendor (choose 8):
    ```bash
    php artisan vendor:publish
    ```
5. Go to `config/app.php` look for `providers` enter the following code:
    ```bash
    Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
    ```
6. Make command (cron ihrs : according to the needs):
    ```bash
    php artisan make:command CronIhrs --command=cron:ihrs
    ```
7. Install kitloong/laravel-migrations-generator to create migration from table exist in database:
    ```bash
    composer require --dev kitloong/laravel-migrations-generator
    ```    
8. Generate table exist to migration laravel:
    ```bash
    php artisan migrate:generate --tables="tbl_makar,permohonan_izin_cuti,career_transition"
    ```   

## Installation Guide If Cloning From This Repository

### Prerequisites
- PHP >= 8.0
- Composer
- XAMPP

### Installation Steps
1. Clone the repository:
    ```bash
    git clone https://github.com/ilham-hdytllh/laravel-task-schedule.git
    ```
2. Navigate into the project directory:
    ```bash
    cd laravel-task-schedule
    ```
3. Install PHP dependencies:
    ```bash
    composer install
    ```
4. Copy the `.env.example` file and rename it to `.env`:
    ```bash
    cp .env.example .env
    ```
5. Tes run:
    ```bash
    php artisan serve
    ```

## Contributors
- **DIT ITTI** - [GitHub](https://github.com/ITCProgrammer)
- **Ilham Hidayatullah** - [GitHub](https://github.com/ilham-hdytllh)

## License
-

