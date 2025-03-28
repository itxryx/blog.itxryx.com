<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web;

use Itxryx\Blog\Web\Response\InternalServerErrorResponse;
use Itxryx\Blog\Web\Response\NotFoundErrorResponse;
use Itxryx\Blog\Web\Response\Response;

class Dispatch
{
    public static function getResponse(Request $req): Response
    {
        if ($req->isOk()) {
            return $req->handlerClassName::run($req);
        } else if ($req->isNotFound()) {
            return new NotFoundErrorResponse($req);
        } else {
            return new InternalServerErrorResponse($req);
        }
    }
}
