# Local Development Setup for Laravel Application

This guide will walk you through setting up the Laravel application locally using **XAMPP** or **Laragon** as your development environment.

## Prerequisites

Before starting, ensure you have the following installed:

- **PHP** (version 8.2 or above)
- **Composer**
- **Laravel Version: 12**
- **XAMPP** or **Laragon**
- **MySQL** (usually included with XAMPP or Laragon)

# Steps to Set Up Locally

## 1. Clone or Download the Repository

First, clone the repository or download it as a `.zip` file. If you download it as a `.zip`, make sure to extract it to a directory of your choice.

## 2. Set Up Your Environment File

- Inside the project folder, find the `.env.example` file and create a copy of it named `.env`.
- Open the `.env` file and update the following key values:

  - **DB_DATABASE**: Set this to the desired database name. For example:
  
    ```bash
    DB_DATABASE=task_db
    ```

  - Ensure that other necessary values (e.g., `DB_USERNAME`, `DB_PASSWORD`) are configured according to your local environment.

## 3. Update Composer Dependencies

- Open **CMD** or **Terminal** and navigate to the project folder.
- Run the following command to install the required dependencies:

  ```bash
  composer update
  ```
- If the command doesn't work due to missing dependencies, you can try:
    ```bash
    composer update --ignore-platform-req=ext-gd
    ```
- Also in **CMD** or **Terminal** do.
  ```bash
    composer dump-autoload
  ```
## 4. Generate the Application Key

Run the following command to generate a unique application key:

```bash
php artisan key:generate
```
This will set the APP_KEY in the .env file, which is essential for securing user sessions and other encrypted data.

## 5. Migrate the Database
Now, you need to set up the database:

- If you have not already created the database, run:

```bash
php artisan migrate
```
- Laravel will automatically create the database and all necessary tables based on the migration files.
- If prompted, type yes to proceed.

## 6. Start the Development Server
After the migration completes, start the Laravel development server by running:

```bash
php artisan serve
```
This will start the server, and you'll see an output like:

```bash
Server running on [http://127.0.0.1:8000]
```
## 7. Access the Application

- Open your browser and navigate to the URL shown in the terminal (e.g., http://127.0.0.1:8000).
- You should now see the Laravel application running.

## 8. Default Credentials

To log in to the application, use the following default credentials:

- **Username**: `admin@admin.com`
- **password**: `12345678`