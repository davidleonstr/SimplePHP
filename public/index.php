<?php
require_once __DIR__ . '/../app/core/ViewRouter.php';
require_once __DIR__ . '/../app/core/Paths.php';

/**
 * Initialize the view router with paths to views and layouts.
 */
$router = new ViewRouter(PATHS::$PUBLIC::$VIEWS, PATHS::$PUBLIC::$LAYOUTS);

/**
 * Axiliary error route.
 */
$router->get(PATHS::$PUBLIC::$URL . '/error', 'error', [
    'code' => ViewRouter::param('code'),
    'title' => ViewRouter::param('title'),
    'error' => ViewRouter::param('error'),
    'button' => ViewRouter::param('button'),
    'to' => ViewRouter::param('to')
]);

/**
 * Axuliary success page route.
 */
$router->get(PATHS::$PUBLIC::$URL . '/success', 'success', [
    'code' => ViewRouter::param('code'),
    'title' => ViewRouter::param('title'),
    'message' => ViewRouter::param('message'),
    'buttonF' => ViewRouter::param('buttonF'),
    'buttonE' => ViewRouter::param('buttonE'),
    'toF' => ViewRouter::param('toF'),
    'toE' => ViewRouter::param('toE')
]);

// Google Auth callback route
$router->get(PATHS::$PUBLIC::$SIMPLEURL . '/auth/callback', 'AuthGoogleCallback', []);

/**
 * Run the router to handle incoming requests.
 */
$router->run();