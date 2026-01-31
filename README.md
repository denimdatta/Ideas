# <img src="/public/ideas.svg" alt="Alt text for the image" width="50" height="50"> Ideas
***

![Status](https://img.shields.io/badge/status-ongoing-orange?style=plastic)
![Type](https://img.shields.io/badge/type-learning-yellow?style=plastic)

## Technologies and Tools Used

* **Technologies**
	* ![React](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=plastic&logo=laravel)
	* ![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.1.10-06B6D4?style=plastic&logo=tailwindcss)
* **Tools**
	* ![Git](https://img.shields.io/badge/Git-2.50.1-F05032?style=plastic&logo=git)
	* ![WebStorm](https://img.shields.io/badge/PhpStorm-2025.3-000000?style=plastic&logo=phpstorm)
	* ![GitKraken](https://img.shields.io/badge/GitKraken-11.1.1-179287?style=plastic&logo=gitkraken)

## Prerequisites
* Php
* Composer
* Laravel
* PostgreSQL

## How to Run
1. `git clone` this repo
2. `cd <workspace>/Ideas`
3. Run `composer install`
4. Generate an application key with `php artisan key:generate`
5. Create a user and database for PostgreSQL. Update `.env` file accordingly.
6. Start PostgreSQL server.
7. Run `php artisan migrate`
8. Start the server with `php artisan serve`

## Code Static Analysis
1. `cd` to the project root directory.
1. Run LaraStan
   ```
   ./vendor/bin/phpstan analyze
   ```
1. If LaraStan fails with memory issues, try increasing the memory limit by running:
   ```
   ./vendor/bin/phpstan analzse --memory-limit=1G
   ```

## Code Style Fixer
1. `cd` to the project root directory.
2. Run Pint
   ```
   ./vendor/bin/pint --parallel
   ```

## Useful Commands
1. Generate PHP Doc Blocks for all models:
   ```
   php artisan ide-helper:models -WR
   ```

## Composer Commands
1. **Code Static Analysis** using ***LaraStan***:
   ```
   composer phpstan
   ```
2. **Code Style Fixer** using ***Pint***:
   ```
   composer pint
   ```
