<?php
require_once __DIR__ . '/../config/bootstrap.php';
use Core\Router;

$router = new Router();

// Auth
$router->get('/', 'AuthController@loginForm');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout', true);

// Dashboard -> listado mutuales
$router->get('/dashboard', 'MutualController@index', true);
$router->get('/mutuales', 'MutualController@index', true);

// Ultimas modificadas
$router->get('/mutuales/recientes', 'MutualController@recent', true);

// CRUD mutuales
$router->get('/mutuales/create', 'MutualController@createForm', true, ['ADMIN']);
$router->post('/mutuales/create', 'MutualController@create', true, ['ADMIN']);
$router->get('/mutuales/view', 'MutualController@ver', true);
$router->get('/mutuales/edit', 'MutualController@editForm', true, ['ADMIN']);
$router->post('/mutuales/edit', 'MutualController@update', true, ['ADMIN']);
$router->post('/mutuales/delete', 'MutualController@delete', true, ['ADMIN']);

// Validación on/off
$router->post('/mutuales/validate', 'MutualController@validateOn', true, ['ADMIN']);
$router->post('/mutuales/desvalidar', 'MutualController@validateOff', true, ['ADMIN']);

// Auditoría
$router->get('/auditoria/ultimos', 'AuditController@recent', true);
$router->get('/auditoria/mutual', 'AuditController@forMutual', true);

// Sugerencias
$router->post('/sugerencias/add', 'SuggestionController@add', true);
$router->get('/sugerencias', 'SuggestionController@index', true, ['ADMIN']);
$router->post('/sugerencias/cerrar', 'SuggestionController@close', true, ['ADMIN']);

$router->dispatch();
