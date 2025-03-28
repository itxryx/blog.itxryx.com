<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Response;

use Itxryx\Blog\Web\Request;

class InternalServerErrorResponse extends Response
{
    public int $code = 500;

    public function __construct(Request $req, string $message = '')
    {
        parent::__construct($req);
        $this->body = $message ?: 'Internal Server Error';
    }
}
