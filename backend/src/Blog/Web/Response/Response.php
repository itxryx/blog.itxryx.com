<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Response;

use Itxryx\Blog\Web\Request;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use RuntimeException;

class Response
{
    public int $code = 200;
    public string $body = "";

    public function __construct(Request $req)
    {}

    public function render(string $template, array $data = []): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../../../template');
        if ($_ENV["DEBUG"] === "1") {
            $op = ['debug' => true];
        } else {
            $op = ['cache' => __DIR__ . '/../../../../var/twig_cache'];
        }
        $twig = new Twig($loader, $op);

        try {
            $this->body = $twig->render($template, $data);
        } catch (LoaderError $e) {
            throw new RuntimeException("Template load error: " . $e->getMessage());
        } catch (RuntimeError $e) {
            throw new RuntimeException("Template runtime error: " . $e->getMessage());
        } catch (SyntaxError $e) {
            throw new RuntimeException("Template syntax error: " . $e->getMessage());
        }
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
