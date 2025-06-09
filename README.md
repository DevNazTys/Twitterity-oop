# Twitterity - Social Media Application

A Twitter-like social media application built with PHP, featuring clean URLs and flexible database configuration.

## Features

- ✅ User registration and authentication
- ✅ Create, edit, and delete posts
- ✅ View personal and all posts
- ✅ Clean URL routing
- ✅ Flexible database configuration (SQLite/MySQL)
- ✅ Modern MVC architecture
- ✅ Responsive design

## Database Configuration

The application supports both SQLite and MySQL databases through environment configuration.

### Configuration File (.env)

Copy the example configuration file and modify it for your environment:

```bash
cp .env.example .env
```

Then edit the `.env` file in the root directory:

```env
# Database Configuration
# Supported values: sqlite, mysql
DB_TYPE=sqlite

# SQLite Configuration (used when DB_TYPE=sqlite)
DB_SQLITE_PATH=database.sqlite

# MySQL Configuration (used when DB_TYPE=mysql)
DB_MYSQL_HOST=localhost
DB_MYSQL_PORT=3306
DB_MYSQL_DATABASE=twitterity
DB_MYSQL_USERNAME=root
DB_MYSQL_PASSWORD=your_password_here
DB_MYSQL_CHARSET=utf8mb4

# Application Settings
APP_NAME=Twitterity
APP_ENV=development
APP_DEBUG=true
```

### Using SQLite (Default)

SQLite is the default database and requires no additional setup:

1. Set `DB_TYPE=sqlite` in `.env`
2. Ensure the SQLite file path is correct: `DB_SQLITE_PATH=database.sqlite`
3. The application will automatically create the database file and tables

### Using MySQL

To switch to MySQL:

1. Install and start MySQL server
2. Create a database named `twitterity`:
   ```sql
   CREATE DATABASE twitterity CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Update `.env` file:
   ```env
   DB_TYPE=mysql
   DB_MYSQL_HOST=localhost
   DB_MYSQL_PORT=3306
   DB_MYSQL_DATABASE=twitterity
   DB_MYSQL_USERNAME=your_username
   DB_MYSQL_PASSWORD=your_password
   ```
4. The application will automatically create the required tables

### Testing Database Configuration

Run the test script to verify your database configuration:

```bash
php test-db.php
```

This will show:
- Current configuration settings
- Database connection status
- Database statistics (user and post counts)
- Instructions for switching databases

## Installation & Setup

1. Clone or download the application files
2. Copy the environment configuration:
   ```bash
   cp .env.example .env
   ```
3. Configure your database in the `.env` file
4. Start the PHP development server:
   ```bash
   php -S localhost:8000
   ```
5. Visit `http://localhost:8000` in your browser

## URL Structure

The application uses clean URLs:

- `/` - Home (redirects based on authentication)
- `/login` - User login
- `/register` - User registration  
- `/dashboard` - User's posts
- `/posts` - All posts
- `/logout` - Logout
- `/post/create` - Create new post
- `/post/edit` - Edit existing post
- `/post/delete/{id}` - Delete post

## Requirements

- PHP 7.4 or higher
- PDO extension
- SQLite extension (for SQLite) OR MySQL/MySQLi (for MySQL)
- Apache with mod_rewrite (for clean URLs)

## Architecture

- **MVC Pattern**: Clear separation of Model, View, and Controller
- **Router Class**: Handles clean URL routing
- **Environment Configuration**: Flexible .env-based configuration
- **Database Abstraction**: Works with both SQLite and MySQL
- **Template System**: Clean separation of HTML and PHP logic

## Development

The application follows modern PHP development practices:

- Object-oriented programming
- Singleton pattern for database connections
- Clean URL routing
- Environment-based configuration
- Template-based views
- AJAX functionality for dynamic features 