<?php
require_once "controllers/PostController.php";
require_once "classes/Auth.php";
require_once "classes/Post.php";

// Require login
Auth::requireLogin();

// Getting all posts
$posts = PostController::getAllPosts();
$userId = Auth::getCurrentUserId();

// Include the view
include 'views/allPosts.php';