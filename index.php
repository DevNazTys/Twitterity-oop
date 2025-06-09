<?php
session_start();

// Load required classes
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Post.php';
require_once __DIR__ . '/classes/Auth.php';
require_once __DIR__ . '/classes/View.php';
require_once __DIR__ . '/classes/Router.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/PageController.php';

// Define routes
Router::get('/', 'PageController::home');
Router::any('/login', 'PageController::login');
Router::any('/register', 'PageController::register');
Router::get('/dashboard', 'PageController::dashboard');
Router::get('/posts', 'PageController::posts');
Router::get('/logout', 'PageController::logout');

// Post routes
Router::post('/post/create', 'PostController::create');
Router::post('/post/edit', 'PostController::edit');
Router::get('/post/delete/{id}', 'PostController::delete');
Router::get('/post/get/{id}', 'PostController::getPost');

// Dispatch the route
Router::dispatch();