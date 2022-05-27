<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Authentication\IdentityInterface;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\IdentifierInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Policy\OrmResolver;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
implements
    AuthenticationServiceProviderInterface,
    AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();
        $this->addPlugin('DhcrCore');
        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }
        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            //$this->addPlugin('DebugKit');
        }
        // Load more plugins here
        $this->addPlugin('Authentication');
        $this->addPlugin('Authorization');
    }

    /**
     * Returns a service provider instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     * @return \Authentication\AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        // Define where users should be redirected to when they are not authenticated
        $service->setConfig([
            'unauthenticatedRedirect' => Router::url([
                'prefix' => false,
                'plugin' => null,
                'controller' => 'users',
                'action' => 'sign-in',
            ]),
            'queryParam' => 'redirect',
        ]);
        $fields = [
            IdentifierInterface::CREDENTIAL_USERNAME => 'email',
            IdentifierInterface::CREDENTIAL_PASSWORD => 'password'
        ];
        $finder = ['all' => [
            'conditions' => ['active' => true],
            'contain' => ['UserRoles', 'Countries']
        ]];
        // Load the authenticators. Session should be first.
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => Router::url([
                'prefix' => false,
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'signIn',
            ]),
        ]);
        // let this provider be the last to return a result
        $envAuthenticator = $service->loadAuthenticator('ServerEnvironment', [
            'mapping' => [
                'HTTP_EPPN' => 'shib_eppn',
                'HTTP_GIVENNAME' => 'first_name',
                'HTTP_SN' => 'last_name',
                'HTTP_EMAIL' => 'email'
            ],
            'token' => 'shib_eppn'
        ]);
        // Kinda ugly hack! Making the loaded authenticator available for further checks in UsersController.
        $service->envAuthenticator = $envAuthenticator;
        // Load identifiers
        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fields,
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'Users',
                'finder' => $finder
            ],
            'passwordHasher' => [
                'className' => 'Authentication.Fallback',
                'hashers' => [
                    'Authentication.Default',
                    [
                        'className' => 'Authentication.Legacy',
                        'hashType' => 'sha1',
                        'salt' => true
                    ],
                ]
            ]
        ]);
        $service->loadIdentifier('Authentication.Token', [
            'tokenField' => 'shib_eppn',
            'dataField' => 'shib_eppn',
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'Users',
                'finder' => $finder
            ]
        ]);
        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();
        return new AuthorizationService($resolver);
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))
            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))
            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            ->add(new BodyParserMiddleware())

            ->add(new AuthenticationMiddleware($this))
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function ($auth, $user) {
                    if ($user->getOriginalData() instanceof IdentityInterface)
                        return $user->setAuthorization($auth);
                    return;
                }
            ]));
        return $middlewareQueue;
    }

    /**
     * Bootrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }
        $this->addPlugin('Migrations');
        // Load more plugins here
    }
}
