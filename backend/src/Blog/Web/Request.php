<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web;

use Itxryx\Blog\Web\Action\Public\PublicTopAction;

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

    public string $handlerClassName = "";
    public bool $isSolvedRouting = false;

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

        // ルーティングで解決
        $this->handlerClassName = PublicTopAction::class;
        $this->isSolvedRouting = true;
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
        return $this->isSolvedRouting;
    }

    public function isNotFound(): bool
    {
        // ルーティングが解決していないか
        return !$this->isSolvedRouting;
    }
}
