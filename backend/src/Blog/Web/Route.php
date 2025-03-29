<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web;

use Itxryx\Blog\Web\Admin\Action as AdminAction;
use Itxryx\Blog\Web\Public\Action as PublicAction;
use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

class Route
{
    // Public画面のルーティング
    static public array $public_routes = [
        ['GET', '/', PublicAction\TopAction::class],
        ['GET', '/posts', PublicAction\ShowArticleList::class],
        ['GET', '/post/{post_id:.+}', PublicAction\ShowArticle::class],
    ];

    // Admin画面のルーティング
    static public array $admin_routes = [
        ['GET', '/admin', AdminAction\TopAction::class],
        ['POST', '/login', AdminAction\LoginAction::class],
        ['POST', '/logout', AdminAction\LogoutAction::class],
        ['POST', '/post/create', AdminAction\CreateArticleAction::class],
        ['POST', '/post/edit/{post_id:.+}', AdminAction\EditArticleAction::class],
        ['POST', '/post/delete/{post_id:.+}', AdminAction\DeleteArticleAction::class],
    ];

    /**
     * @param string $method
     * @param string $uri
     * @return array
     *
     * Public / Admin のルーティングを解決
     */
    static public function resolve(string $method, string $uri): array
    {
        $dispatcher = simpleDispatcher(static::getRouteRegisteredHandler());

        $pos = strpos($uri, '?');
        if (false !== $pos) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $route_info = $dispatcher->dispatch($method, $uri);

        if ($route_info[0] === Dispatcher::FOUND) {

            // FOUND!!!
            return [
                $route_info[0], // status
                $route_info[1], // handler
                $route_info[2]  // path params
            ];
            // NOT FOUND...
        } else {
            return [
                $route_info[0], // status
                null,
                null
            ];
        }
    }

    /**
     * @return callable
     *
     * Public / Admin のルーティングを登録
     */
    static private function getRouteRegisteredHandler(): callable
    {
        return function (RouteCollector $r) {
            foreach (Route::$public_routes as $line) {
                $r->addRoute($line[0], $line[1], $line[2]);
            }
            foreach (Route::$admin_routes as $line) {
                $r->addRoute($line[0], $line[1], $line[2]);
            }
        };
    }
}
