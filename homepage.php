<?php
require_once "controllers/PostController.php";
require_once "classes/Auth.php";
require_once "classes/Post.php";

// Require login
Auth::requireLogin();

// Get user posts
$userId = Auth::getCurrentUserId();
$posts = PostController::getUserPosts($userId);

// Include the view
include 'views/homepage.php';