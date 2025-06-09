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
DB_SQLITE_PATH=databases/database.sqlite

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
2. Ensure the SQLite file path is correct: `DB_SQLITE_PATH=databases/database.sqlite`
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
php scripts/test-db.php
```

This will show:
- Current configuration settings
- Database connection status
- Database statistics (user and post counts)
- Instructions for switching databases

### Generating Test Data

Use the data seeding script to generate dummy users and posts for testing:

```bash
php scripts/seed-data.php
```

This interactive script will:
- Show current database statistics
- Ask how many users to create (1-100)
- Ask how many posts to create (1-500)
- Generate realistic dummy data with:
  - Random names from common first/last name combinations
  - Realistic email addresses
  - Varied post content (general and tech-focused)
  - Progress feedback during generation

All generated users have the password `password123` for easy testing.

## Installation & Setup

### Option 1: Standard PHP Development Server

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

### Option 2: Using DDEV (Recommended for Development)

[DDEV](https://ddev.readthedocs.io/) provides a consistent Docker-based development environment:

1. **Install DDEV** following the [official installation guide](https://ddev.readthedocs.io/en/stable/#installation)

2. **Initialize DDEV in your project:**
   ```bash
   ddev config --project-type=php --php-version=8.1
   ```

3. **Copy the environment configuration:**
   ```bash
   cp .env.example .env
   ```

4. **Configure for DDEV (update `.env`):**
   ```env
   # Use MySQL with DDEV
   DB_TYPE=mysql
   DB_MYSQL_HOST=db
   DB_MYSQL_PORT=3306
   DB_MYSQL_DATABASE=db
   DB_MYSQL_USERNAME=db
   DB_MYSQL_PASSWORD=db
   DB_MYSQL_CHARSET=utf8mb4
   ```

5. **Start DDEV:**
   ```bash
   ddev start
   ```

6. **Create database tables:**
   ```bash
   ddev exec php scripts/test-db.php
   ```

7. **Generate test data (optional):**
   ```bash
   ddev exec php scripts/seed-data.php
   ```

8. **Access your application:**
   - Web: `https://twitterity.ddev.site` (or your project name)
   - Database: Use `ddev describe` to see database connection details

**DDEV Useful Commands:**
```bash
ddev start          # Start the environment
ddev stop           # Stop the environment
ddev restart        # Restart services
ddev ssh            # SSH into web container
ddev mysql          # Access MySQL CLI
ddev describe       # Show project details and URLs
ddev logs           # View container logs
```

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
- **Organized Assets**: Separate folders for CSS (`css/`) and JavaScript (`js/`) files
- **SCSS Support**: Modular SCSS architecture with variables, mixins, and organized components
- **Database Organization**: Dedicated `databases/` folder for database files

## SCSS Development

The application uses SCSS for maintainable and organized stylesheets:

### SCSS Structure

```
scss/
├── components/          # Reusable UI components
│   ├── _forms.scss     # Form elements and buttons
│   ├── _header.scss    # Header navigation and logo
│   └── _posts.scss     # Post-related components
├── layouts/            # Layout and base styles
│   ├── _base.scss      # Base HTML/body styles
│   └── _wrapper.scss   # Main layout wrapper
├── pages/              # Page-specific styles
│   └── _auth.scss      # Login and register pages
├── utils/              # Utilities and helpers
│   ├── _variables.scss # Colors, fonts, spacing
│   ├── _mixins.scss    # Reusable mixins
│   └── _fonts.scss     # Font definitions
└── main.scss          # Main import file
```

### Compiling SCSS

**Option 1: Using Sass CLI (Recommended)**
```bash
# Install Sass globally
npm install -g sass

# Compile once
sass scss/main.scss css/style.css

# Watch for changes during development
sass --watch scss/main.scss css/style.css

# Build for production (compressed)
sass scss/main.scss css/style.css --style compressed
```

**Option 2: Using npm scripts**
```bash
# Install dependencies
npm install

# Available scripts
npm run scss          # Compile once
npm run scss:watch    # Watch for changes
npm run scss:build    # Build for production (compressed)
```

**Option 3: PHP compilation helper**
```bash
# View compilation instructions and SCSS structure
php scripts/compile-scss.php
```

## Development

The application follows modern PHP development practices:

- Object-oriented programming
- Singleton pattern for database connections
- Clean URL routing
- Environment-based configuration
- Template-based views
- AJAX functionality for dynamic features
- Modular SCSS architecture with variables and mixins 