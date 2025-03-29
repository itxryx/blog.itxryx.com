<?php
declare(strict_types=1);

namespace Itxryx\Blog\Web\Public\Action;

use Itxryx\Blog\Web\Request;
use Itxryx\Blog\Web\Response\Response;

class ShowArticleList
{
    static function run(Request $req): Response
    {
        $res = new Response($req);
        $res->render('public/web/page/show_posts_list.twig');
        return $res;
    }
}
