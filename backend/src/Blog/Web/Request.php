<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web;

class Request
{
    public string $method;
    public string $uri;
    public array $get;
    public array $post;
    public array $cookie;
    public array $files;
    public array $request;
    public array $session;

    // Dispatcher::NOT_FOUND = 0
    // Dispatcher::FOUND = 1
    // Dispatcher::METHOD_NOT_ALLOWED = 2
    public int $routeResolveStatus = 0;
    public ?string $handlerClassName = "";
    public ?array $pathParams = [];

    public function __construct(
        array $server = [],
        array $get = [],
        array $post = [],
        array $cookie = [],
        array $files = [],
        array $request = [],
        array $session = [],
    ){
        $this->method = $server['REQUEST_METHOD'] ?? "GET";
        $this->uri = $server['REQUEST_URI'] ?? "";
        $this->get = $get;
        $this->post = $post;
        $this->cookie = $cookie;
        $this->files = $files;
        $this->request = $request;
        $this->session = $session;

        [
            $this->routeResolveStatus,
            $this->handlerClassName,
            $this->pathParams
        ] = Route::resolve($this->method, $this->uri);

    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function get(string $key): string
    {
        return $this->get[$key] ?? "";
    }

    public function post(string $key): string
    {
        return $this->post[$key] ?? "";
    }

    public function isOk(): bool
    {
        // ルーティングが解決しているか
        return $this->routeResolveStatus === 1;
    }

    public function isNotFound(): bool
    {
        // ルーティングが解決していないか
        return $this->routeResolveStatus === 0;
    }
}
