# Movie Management API

This is a RESTful API built with Laravel for managing movies, directors, genres, and cast members. It includes authentication via JWT tokens.

## Features and Functionality

*   **User Authentication:**
    *   Register new users with name, email, and password.
    *   Login existing users and receive a JWT token for authentication.
*   **Movie Management:**
    *   Retrieve a list of all movies with related director, genres, and cast members.
    *   Create new movies with title, description, release date, duration, director, genres, and cast.
    *   Retrieve a specific movie by its ID.
    *   Update existing movie information.
    *   Delete movies.
*   **Director Management:**
    *   Retrieve a list of all directors.
    *   Create new directors with full name, first name, last name and gender.
    *   Retrieve a specific director by its ID.
    *   Update existing director information.
    *   Delete directors.
*   **Genre Management:**
    *   Retrieve a list of all genres.
    *   Create new genres with descriptions.
    *   Retrieve a specific genre by its ID.
    *   Update existing genre information.
    *   Delete genres.
*   **Cast Management:**
    *   Retrieve a list of all cast members.
    *   Create new cast members with full name, first name, last name and gender.
    *   Retrieve a specific cast member by its ID.
    *   Update existing cast member information.
    *   Delete cast members.
*   **API Protection:**
    *   Uses JWT (JSON Web Tokens) for authentication, ensuring only authorized users can access the API endpoints.

## Technology Stack

*   **Laravel:** PHP framework for web application development.
*   **PHP:** Server-side scripting language.
*   **MySQL/SQLite:** Database for storing movie data (configured in `.env` and `config/database.php`).
*   **JWT (Firebase JWT):** Library for generating and verifying JSON Web Tokens (`Firebase/JWT`).
*   **Composer:** Dependency manager for PHP.

## Prerequisites

*   PHP >= 8.1
*   Composer
*   MySQL or SQLite
*   Node.js and npm (for compiling assets, if needed)

## Installation Instructions

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/SeanSoulong/movie_management.git
    cd movie_management
    ```

2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Copy the `.env.example` file to `.env` and configure database settings:**

    ```bash
    cp .env.example .env
    ```

    Edit the `.env` file to configure the database connection.  For MySQL:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

    Or for SQLite:

    ```
    DB_CONNECTION=sqlite
    DB_DATABASE=database.sqlite
    ```

    Make sure the `database.sqlite` file exists in the `database` directory, or create it.

4.  **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5.  **Run database migrations:**

    ```bash
    php artisan migrate
    ```

6.  **Seed the database (optional, but recommended for initial data):**

    ```bash
    php artisan db:seed
    ```

    This will populate the database with sample directors, genres, cast and movies based on `database/seeders/`.

7.  **Generate JWT Secret Key**

    ```bash
    php artisan jwt:secret
    ```

8.  **(Optional) Compile assets:**

    If you want to use the frontend assets, you'll need to compile them.

    ```bash
    npm install
    npm run build
    ```

9.  **Serve the application:**

    ```bash
    php artisan serve
    ```

    This will start the development server, usually at `http://127.0.0.1:8000`.

## Usage Guide

The API endpoints are protected by JWT authentication. You'll need to register a user and log in to obtain a token before accessing most of the routes.

### Authentication

*   **Register:** `POST /register`

    *   Parameters: `name`, `email`, `password`
    *   Example:

        ```json
        {
            "name": "John Doe",
            "email": "john.doe@example.com",
            "password": "secret123"
        }
        ```

    *   Returns:

        ```json
        {
            "status": true,
            "message": "User registered successfully",
            "data": {
                "name": "John Doe",
                "email": "john.doe@example.com",
                "updated_at": "2024-06-11T00:00:00.000000Z",
                "created_at": "2024-06-11T00:00:00.000000Z",
                "id": 1
            }
        }
        ```

*   **Login:** `POST /login`

    *   Parameters: `email`, `password`
    *   Example:

        ```json
        {
            "email": "john.doe@example.com",
            "password": "secret123"
        }
        ```

    *   Returns:

        ```json
        {
            "message": "JWT token generated successfully",
            "token": "your_jwt_token"
        }
        ```

### API Endpoints

All the following endpoints require a valid JWT token in the `Authorization` header.

```
Authorization: Bearer your_jwt_token
```

#### Movies

*   `GET /movies`: Retrieve all movies.
*   `POST /movies`: Create a new movie.
    *   Parameters: `movie_title`, `movie_description`, `movie_release_date`, `movie_duration`, `director_id`, `genre_ids` (array), `cast_ids` (array)
    *   Example:

        ```json
        {
            "movie_title": "New Movie",
            "movie_description": "A great movie",
            "movie_release_date": "2024-01-01",
            "movie_duration": 120,
            "director_id": 1,
            "genre_ids": [1, 2],
            "cast_ids": [1]
        }
        ```

*   `GET /movies/{id}`: Retrieve a specific movie.
*   `PUT /movies/{id}`: Update a movie.
*   `DELETE /movies/{id}`: Delete a movie.

#### Directors

*   `GET /directors`: Retrieve all directors.
*   `POST /directors`: Create a new director.
    *   Parameters: `director_full_name`, `director_first_name`, `director_last_name`, `director_gender`
    *   Example:

        ```json
        {
            "director_full_name": "Jane Doe",
            "director_first_name": "Jane",
            "director_last_name": "Doe",
            "director_gender": "F"
        }
        ```
*   `GET /directors/{id}`: Retrieve a specific director.
*   `PUT /directors/{id}`: Update a director.
*   `DELETE /directors/{id}`: Delete a director.

#### Genres

*   `GET /genres`: Retrieve all genres.
*   `POST /genres`: Create a new genre.
    *   Parameters: `genre_description`
    *   Example:

        ```json
        {
            "genre_description": "Horror"
        }
        ```
*   `GET /genres/{id}`: Retrieve a specific genre.
*   `PUT /genres/{id}`: Update a genre.
*   `DELETE /genres/{id}`: Delete a genre.

#### Cast

*   `GET /casts`: Retrieve all cast members.
*   `POST /casts`: Create a new cast member.
    *   Parameters: `cast_full_name`, `cast_first_name`, `cast_last_name`, `cast_gender`
    *   Example:

        ```json
        {
            "cast_full_name": "Keanu Reeves",
            "cast_first_name": "Keanu",
            "cast_last_name": "Reeves",
            "cast_gender": "M"
        }
        ```
*   `GET /casts/{id}`: Retrieve a specific cast member.
*   `PUT /casts/{id}`: Update a cast member.
*   `DELETE /casts/{id}`: Delete a cast member.

## API Documentation

### Authentication

The API uses JWT (JSON Web Tokens) for authentication. After a successful login, the API will return a JWT that must be included in the `Authorization` header of subsequent requests.

### Models

*   **User:**  Represents a registered user. (Model: `App\Models\User`)
*   **Movie:** Represents a movie. (Model: `App\Models\Movie`)
    *   `movie_id` (integer, primaryKey)
    *   `movie_title` (string)
    *   `movie_description` (string, nullable)
    *   `movie_release_date` (date)
    *   `movie_duration` (integer)
    *   `director_id` (integer, foreign key to `directors`)
*   **Director:** Represents a director. (Model: `App\Models\Director`)
    *   `director_id` (integer, primaryKey)
    *   `director_full_name` (string)
    *   `director_first_name` (string)
    *   `director_last_name` (string)
    *   `director_gender` (string)
*   **Genre:** Represents a genre. (Model: `App\Models\Genre`)
    *   `genre_id` (integer, primaryKey)
    *   `genre_description` (string)
*   **Cast:** Represents a cast member. (Model: `App\Models\Cast`)
    *   `cast_id` (integer, primaryKey)
    *   `cast_full_name` (string)
    *   `cast_first_name` (string)
    *   `cast_last_name` (string)
    *   `cast_gender` (string)

### Middleware

*   **`EnsureTokenIsValid`:** This middleware (`app/Http/Middleware/EnsureTokenIsValid.php`) is applied to all API routes (except `/register` and `/login`).  It validates the JWT token in the `Authorization` header and retrieves the authenticated user. If the token is invalid or expired, it returns a 401 Unauthorized response.

### Validation

Input data validation is handled within the controllers using Laravel's validation features.  See specific controller methods for validation rules. For example, in `app/Http/Controllers/Api/AuthController.php`:

```php
$validated = $request->validate([
    'name' => 'required|string|max:100',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|string|min:6',
], [
    'name.required' => 'The user name is required.',
    'email.required' => 'The email address is required.',
    'email.unique' => 'The email address has already been taken.',
    'password.required' => 'The password is required.',
    'password.min' => 'The password must be at least 6 characters.',
    'email.email' => 'The email address must be a valid email format.',
    'name.string' => 'The user name must be a string.',
    'name.max' => 'The user name may not be greater than 100 characters.'
]);
```

This validation ensures data integrity and prevents errors.

## Contributing Guidelines

Contributions are welcome! Please follow these guidelines:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Write tests for your changes.
4.  Ensure all tests pass.
5.  Submit a pull request.

## License Information

License is not specified.

## Contact/Support Information

For questions or support, please open an issue on the GitHub repository:  https://github.com/SeanSoulong/movie_management
