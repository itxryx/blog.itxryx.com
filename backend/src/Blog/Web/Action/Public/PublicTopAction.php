<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Action\Public;

use Itxryx\Blog\Web\Request;
use Itxryx\Blog\Web\Response;

class PublicTopAction
{
    static function run(Request $req): Response
    {
        $res = new Response($req);
        $res->render("hi!");
        return $res;
    }
}
