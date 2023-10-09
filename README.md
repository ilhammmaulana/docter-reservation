# Doctor Reservation API and Dashboard (Laravel 8.0)

This project combines a RESTful API and a sophisticated dashboard built with Laravel 8.0 and PHP 7.4.2 for making doctor reservations. It simplifies the process of booking appointments with doctors in Semarang while providing an interactive dashboard for managing the system.

## Table of Contents

-   [Features](#features)
-   [Prerequisites](#prerequisites)
-   [Getting Started](#getting-started)
-   [API Endpoints](#api-endpoints)
-   [Dashboard](#dashboard)
-   [Contributing](#contributing)
-   [License](#license)

## Features

### API (For Users and Doctors)

-   User authentication with JWT tokens.
-   Endpoints for searching and booking appointments with doctors.
-   User and doctor profiles.
-   Real-time notifications for appointment status updates.
-   Role-based access control for users and doctors.

### Dashboard (For Admin and Doctors)

-   Admin dashboard built with Argon template for easy management.
-   Doctor dashboard for managing appointments and profiles.
-   Real-time updates on appointment requests.
-   CRUD operations for managing doctors and appointments.
-   Beautifully designed UI for a seamless experience.

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   [PHP](https://www.php.net/) 7.4.2 or later
-   [Composer](https://getcomposer.org/) (for Laravel)
-   [Node.js](https://nodejs.org/) (for managing frontend dependencies)

## Getting Started

To get the Doctor Reservation API and Dashboard up and running on your local machine, follow these steps:

1. Clone the repository:

    ```shell
    git clone https://github.com/yourusername/doctor-reservation.git
    ```

2. Navigate to the project directory:

    ```shell
    cd doctor-reservation
    ```

3. Install PHP dependencies:

    ```shell
    composer install
    ```

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the `.env` file with your configuration, including your database settings and application key:

    ```shell
    cp .env.example .env
    php artisan key:generate
    ```

5. Install JavaScript dependencies:

    ```shell
    npm install
    ```

6. Generate asset files:

    ```shell
    npm run dev
    ```

7. Migrate the database:

    ```shell
    php artisan migrate
    ```

8. Start the Laravel development server:

    ```shell
    php artisan serve
    ```

Now, you can access the API at `http://127.0.0.1:8000/api` and the Dashboard at `http://127.0.0.1:8000/`.

## API Endpoints

For detailed information about available API endpoints and their usage, refer to the [API documentation](#api-documentation).

## Dashboard

The dashboard provides an interactive interface for doctors and administrators to manage appointments, doctors, and users. For more details on how to use the dashboard, refer to the [Dashboard documentation](#dashboard-documentation).

## Contributing

Contributions are welcome! If you would like to contribute to this project, please follow these guidelines:

1. Fork the project.
2. Create a new branch for your feature (`git checkout -b feature/your-feature`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to your branch (`git push origin feature/your-feature`).
5. Open a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
