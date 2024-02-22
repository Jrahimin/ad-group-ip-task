# IP Management System
A web-based IP management system where users can manage IP addresses and monitor audit trails.

## Features
### React Frontend 
A dynamic and responsive user interface for managing IP addresses, built with React to deliver a seamless single-page application experience.
### User Authentication
Secure login system with API token management using Laravel Sanctum.
### IP Management
Users can view, add and edit IP addresses with labels for easy management.
### Audit Trail
Records and displays user activity, such as logins, IP additions, and modifications, enhancing security and accountability.

## Installation Prerequisites
Before installing the IP Management System, ensure you have the following installed on your system:
- Docker (for Docker installation)
- PHP >= 8.1
- Composer
- Node.js and npm

## Installation Process
Follow these steps to install and start the IP Management System:
### With Docker:
- Clone the repository
- Start the Docker containers with `docker compose up -d` or for mac m1/m2 chip run `DOCKER_DEFAULT_PLATFORM=linux/amd64 docker-compose up  -d`
- Access the application shell with `docker exec -it ad bash`
- Run `composer install` to install PHP dependencies.`
- Run `npm install` to install Node.js dependencies.`
- Run `cp .env.docker .env` to Rename .env.docker to .env
- Generate an application key with `php artisan key:generate`
- Cache the configuration files with `php artisan config:cache`
- Run `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- Run migrations with `php artisan migrate`
- Seed the database with `php artisan db:seed`
- The application will be running on `http://localhost:8000/`

### Without Docker:
- Clone the repository
- Run `composer install` to install PHP dependencies.`
- Run `npm install` to install Node.js dependencies.`
- Run `cp .env.docker .env` to Rename .env.docker to .env
- Generate an application key with `php artisan key:generate`
- Cache the configuration files with `php artisan config:cache`
- - Run `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- Run migrations with `php artisan migrate`
- Seed the database with `php artisan db:seed`
- Serve the application with php artisan serve and access it at `http://localhost:8000/` (or the port provided).

### Run Test
- Access the application shell with `docker exec -it ad bash`
- Run `php artisan test --testsuite=Feature --filter=IpManagementTest`

## Usage
To start using the IP Management System:
### Login Credential: 
- email: admin@gmail.com 
- password: 123456
### Managing IPs 
After logging in, user will be redirected to the IP management page, where user can add or edit IP addresses.
User can also see the added IP addresses in the same page. 
### Audit Trail 
Visit the audit trail section to monitor user actions within the application.