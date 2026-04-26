<?php
/**
 * Главный файл приложения
 */

// Запуск сессии
session_start();

// Показываем ошибки в разработке
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключаем основные классы
require_once __DIR__ . '/app/Database.php';
require_once __DIR__ . '/app/Logger.php';
require_once __DIR__ . '/app/Validator.php';
require_once __DIR__ . '/app/Security.php';
require_once __DIR__ . '/app/Router.php';

// Подключаем модели
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Models/Post.php';
require_once __DIR__ . '/app/Models/Category.php';
require_once __DIR__ . '/app/Models/Media.php';
require_once __DIR__ . '/app/Models/Comment.php';
require_once __DIR__ . '/app/Models/Settings.php';

// Подключаем middleware
require_once __DIR__ . '/app/Middleware/AuthMiddleware.php';

// Подключаем контроллеры
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';
require_once __DIR__ . '/app/Controllers/PostController.php';
require_once __DIR__ . '/app/Controllers/CategoryController.php';
require_once __DIR__ . '/app/Controllers/MediaController.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
require_once __DIR__ . '/app/Controllers/CommentController.php';
require_once __DIR__ . '/app/Controllers/SettingsController.php';
require_once __DIR__ . '/app/Controllers/FrontendController.php';

// Определяем маршруты
// Аутентификация
Router::get('/login', function() {
    (new AuthController())->loginPage();
});

Router::post('/login', function() {
    (new AuthController())->login();
});

Router::get('/logout', function() {
    (new AuthController())->logout();
});

Router::get('/forgot-password', function() {
    (new AuthController())->forgotPassword();
});

Router::post('/forgot-password', function() {
    (new AuthController())->sendResetLink();
});

// Админ-панель
Router::get('/admin/dashboard', function() {
    (new DashboardController())->index();
});

// Посты
Router::get('/admin/posts', function() {
    (new PostController())->index();
});

Router::get('/admin/posts/create', function() {
    (new PostController())->create();
});

Router::post('/admin/posts', function() {
    (new PostController())->store();
});

Router::get('/admin/posts/{id}/edit', function($id) {
    (new PostController())->edit($id);
});

Router::post('/admin/posts/{id}', function($id) {
    (new PostController())->update($id);
});

Router::get('/admin/posts/{id}/delete', function($id) {
    (new PostController())->delete($id);
});

Router::get('/admin/posts/{id}/publish', function($id) {
    (new PostController())->publish($id);
});

// Категории
Router::get('/admin/categories', function() {
    (new CategoryController())->index();
});

Router::get('/admin/categories/create', function() {
    (new CategoryController())->create();
});

Router::post('/admin/categories', function() {
    (new CategoryController())->store();
});

Router::get('/admin/categories/{id}/edit', function($id) {
    (new CategoryController())->edit($id);
});

Router::post('/admin/categories/{id}', function($id) {
    (new CategoryController())->update($id);
});

Router::get('/admin/categories/{id}/delete', function($id) {
    (new CategoryController())->delete($id);
});

// Медиабиблиотека
Router::get('/admin/media', function() {
    (new MediaController())->index();
});

Router::post('/admin/media/upload', function() {
    (new MediaController())->upload();
});

Router::post('/admin/media/{id}/delete', function($id) {
    (new MediaController())->delete($id);
});

Router::get('/api/media', function() {
    (new MediaController())->api();
});

Router::get('/api/media/{id}', function($id) {
    (new MediaController())->api($id);
});

// Пользователи
Router::get('/admin/users', function() {
    (new UserController())->index();
});

Router::get('/admin/users/create', function() {
    (new UserController())->create();
});

Router::post('/admin/users', function() {
    (new UserController())->store();
});

Router::get('/admin/users/{id}/edit', function($id) {
    (new UserController())->edit($id);
});

Router::post('/admin/users/{id}', function($id) {
    (new UserController())->update($id);
});

Router::get('/admin/users/{id}/delete', function($id) {
    (new UserController())->delete($id);
});

// Профиль пользователя
Router::get('/admin/profile', function() {
    (new UserController())->profile();
});

Router::post('/admin/profile', function() {
    (new UserController())->updateProfile($_SESSION['user_id']);
});

// Комментарии
Router::get('/admin/comments', function() {
    (new CommentController())->index();
});

Router::get('/admin/comments/{id}/approve', function($id) {
    (new CommentController())->approve($id);
});

Router::get('/admin/comments/{id}/reject', function($id) {
    (new CommentController())->reject($id);
});

Router::get('/admin/comments/{id}/delete', function($id) {
    (new CommentController())->delete($id);
});

// Настройки
Router::get('/admin/settings', function() {
    (new SettingsController())->index();
});

Router::post('/admin/settings', function() {
    (new SettingsController())->update();
});

// Фронтенд
Router::get('/', function() {
    (new FrontendController())->index();
});

Router::get('/post/{slug}', function($slug) {
    (new FrontendController())->post($slug);
});

Router::get('/category/{slug}', function($slug) {
    (new FrontendController())->category($slug);
});

Router::get('/search', function() {
    (new FrontendController())->search();
});

// Обработка запроса
Router::dispatch();
