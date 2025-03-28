<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Response;

use Itxryx\Blog\Web\Request;

class Response
{
    public int $code = 200;
    public string $body = "";

    public function __construct(Request $req)
    {}

    public function render(string $text): void
    {
        // Twigのレンダリングを行う
        $this->body = $text;
    }

    public function writeHeader(): void
    {
        http_response_code($this->code);
    }

    public function writeBody(): void
    {
        echo $this->body;
    }
}
