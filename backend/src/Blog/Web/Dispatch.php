<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web;

class Dispatch
{
    public static function getResponse(Request $req): Response
    {
        if ($req->isOk()) {
            return $req->handlerClassName::run($req);
        } else if ($req->isNotFound()) {
            // return new NotFoundResponse($req);
        } else {
            // return new InternalServerErrorResponse($req);
        }
    }
}
