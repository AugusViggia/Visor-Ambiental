# Visor Ambiental



## Getting started
Wellcome!

## Name
Visor Ambiental. 

## Description
Is a project that is used to monitor the environment of the Salta province.

## Installation
### Server Requirements
The project has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions:

- PHP >= 8.0
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Usage
Take a look at the [User Manual](https://).

## Roadmap

- Develop the key features of the project.
- Deploy to the test environment.
- Test the project and solve issues.
- Prepare for the release.
- Deploy to the production environment.

## Contributing
With Docker and Docker Compose, using Laravel Sail.

You must have Docker installed and running and Docker-Compose installed too.
You must have Composer installed.

Clone the repository and run the following commands:

```bash
git clone this_repo_url_prefer_@git_not_https
cd visor-ambiental
cp .env.example .env
composer install
vendor/bin/sail up
vendor/bin/sail artisan key:generate
vendor/bin/sail artisan migrate --seed
vendor/bin/sail npm install
vendor/bin/sail npm run dev
```
To see profile user photo:

```bash
vendor/bin/sail artisan storage:link

or

php artisan storage:link

```

**Note:**
Before run sail up command you must configure the .env file. Setting Database access, and some ports if they are taken by others apps.
