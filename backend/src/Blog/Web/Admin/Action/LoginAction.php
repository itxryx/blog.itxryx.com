<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Admin\Action;

use Itxryx\Blog\Web\Request;
use Itxryx\Blog\Web\Response\Response;

class LoginAction
{
    static function run(Request $req): Response
    {
        $res = new Response($req);
        $res->render("hi!");
        return $res;
    }
}
