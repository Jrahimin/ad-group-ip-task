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

## Technical Implementations
#### Dockerization: 
Containerized the entire application for streamlined development and deployment.
#### Backend Framework: 
Developed using PHP Laravel, providing a robust server-side architecture.
#### Frontend SPA: 
Utilized React for a dynamic single-page application.
#### Authentication: 
Leveraged Laravel Sanctum for secure token-based user authentication. Laravel Sanctum was chosen for its simplicity and effectiveness in handling SPA authentication. It provides a lightweight package for token-based API authentication. This aligns well with SPAs that require a user context without the complexity of OAuth systems.
#### Database:
Used MySQL database for reliability, performance, and ease of use. As an open-source relational database, it offers comprehensive support. Its compatibility with Laravel and scalability options also make it an ideal choice for web applications, supporting both small projects and enterprise-level demands.
#### Data Access Layer: 
Implemented repository pattern. It enhances the application by abstracting the data access layer, promoting cleaner, more maintainable code. It decouples the business logic from data access logic, making the system more robust to changes in the database or ORM. Additionally, it simplifies unit testing by allowing easy mocking of the data access layer.
#### Caching: 
Integrated Redis for enhanced performance through efficient data caching. Redis was selected over alternatives like Memcache due to its advanced capabilities, including persistence, built-in data structure support, and high availability features. It offers fast, in-memory data storage and retrieval, making it ideal for enhancing application performance through caching frequently accessed data.
#### Audit Trail: 
Automated audit trail entries for user activities like login using Laravel's job dispatching. Employed model observers for generating an audit trail that reflects CRUD operations on IP addresses.
#### Unit Testing: 
Incorporated test cases, specifically testing the IP list fetching functionality to ensure application reliability.
### Alternate approach
- We can use Angular or VueJs for the SPA.
- We can use Laravel passport for authentication if we need Oauth based authentication.
- We can introduce service layer to manage more complex business logic.
- We can add laravel supervisor to manage queue
- For complex audit trail or reporting we can use NoSQL like Mongo.

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