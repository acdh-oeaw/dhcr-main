<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 * 
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Http\Middleware\CsrfProtectionMiddleware;

return static function (RouteBuilder $routes) {
    /**
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        // Register scoped middleware for in scopes.
        $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httponly' => true
        ]));

        /**
         * Apply a middleware to the current route scope.
         * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
         */
        $builder->applyMiddleware('csrf');

        /**
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, src/Template/Pages/home.ctp)...
         */
        $builder->connect('/', ['controller' => 'Courses', 'action' => 'index']);

        $builder->connect('/iframe', ['controller' => 'Courses', 'action' => 'index']);
        $builder->connect('/courses/iframe', ['controller' => 'Courses', 'action' => 'index']);
        $builder->connect('/iframe/*', ['controller' => 'Courses', 'action' => 'index']);
        $builder->connect('/courses/iframe/*', ['controller' => 'Courses', 'action' => 'index']);

        $builder->connect('/info', ['controller' => 'Pages', 'action' => 'info']);
        $builder->connect('/pages/info', ['controller' => 'Pages', 'action' => 'info']);

        $builder->connect('/follow', ['controller' => 'Pages', 'action' => 'follow']);
        $builder->connect('/national-moderators', ['controller' => 'Pages', 'action' => 'nationalModerators']);

        /*  PA 2023-04-19: The following route is for backwards compatibility with published link and should not be removed.
            The old link was: /pages/news#social-media  */
        $builder->connect('/pages/news', ['controller' => 'Pages', 'action' => 'follow', 'social-media']);

        $builder->connect('/pages/*', 'Pages::display');

        // re-routing the login form irritates the Authentication Component
        //$routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        //$routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        //$routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);

        // Added routes for the new backend
        $builder->connect('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->connect('/cities', ['controller' => 'Cities', 'action' => 'index']);
        $builder->connect('/institutions', ['controller' => 'Institutions', 'action' => 'index']);
        $builder->connect('/languages', ['controller' => 'Languages', 'action' => 'index']);
        $builder->connect('/invite-translations', ['controller' => 'inviteTranslations', 'action' => 'index']);
        $builder->connect('/logentries', ['controller' => 'Logentries', 'action' => 'index']);
        $builder->connect(
            '/faq-questions/{categoryId}',
            ['controller' => 'FaqQuestions', 'action' => 'index'],
            ["pass" => ["categoryId"], "categoryId" => "[1-3]"]
        );
        $builder->connect(
            '/faq/{categoryName}',
            ['controller' => 'FaqQuestions', 'action' => 'faqList'],
            ["pass" => ["categoryName"]],
        );
        $builder->connect('/help/users-access-workflows', ['controller' => 'FaqQuestions', 'action' => 'usersAccessWorkflows']);

        # "Legacy support" for API v1. Redirect v1 landing page to v2 landing page. Other v1 calls result in 404.
        $builder->redirect('/api/v1/', '/api/v2/', ['status' => 301]);

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });
};

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
