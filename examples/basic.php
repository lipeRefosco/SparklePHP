<?php

require_once "./vendor/autoload.php";

use SparklePHP\Socket\Protocol\Http\Request;
use SparklePHP\Socket\Protocol\Http\Response;
use SparklePHP\Sparkle;

$address = 'localhost';
$port = 8080;

$app = new Sparkle($address, $port);

$app->get("/", function (Request $req, Response $res) {
    $acceptIsJson = !empty($req->headers->fields["Accept"]) && $req->headers->fields["Accept"] === "application/json";
    if($acceptIsJson) {
        $res->sendJSON($req);
        return;
    }

    
    $reqJson = str_replace(":{", ": {<br>", str_replace(",", ", <br>", json_encode($req)));
    
    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <title>Title of the document</title>
    </head>
    <body>
        <h1>holla que tal</h1>
        <pre>$reqJson</pre>
    </body>
    </html>
    HTML;
    
    $res->sendHTML($html);
});

$app->get("/html", function ($_, Response $res) {

    $teste = "hello world";

    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <title>Title of the document</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
        html,
        body {
            height: 100%;
        }
        body {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
        }
        .header-menu,
        footer {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .header-menu {
            justify-content: flex-end;
            height: 60px;
            background: #1c87c9;
            color: #fff;
        }
        h2 {
            margin: 0 0 8px;
        }
        ul li {
            display: inline-block;
            padding: 0 10px;
            list-style: none;
        }
        aside {
            flex: 0.4;
            height: 165px;
            padding-left: 15px;
            border-left: 1px solid #666;
        }
        section {
            flex: 1;
            padding-right: 15px;
        }
        footer {
            padding: 0 10px;
            background: #ccc;
        }
        </style>
    </head>
    <body>
        <header class="header-menu">
        <nav>
            <ul>
            <li>Menu item</li>
            <li>Menu item</li>
            <li>Menu item</li>
            </ul>
        </nav>
        </header>
        <section>
        <article>
            <header>
            <h1>{$teste}</h1>
            <h2>Learn HTML</h2>
            <small>Hyper Text Markup Language</small>
            </header>
            <p>Our free HTML tutorial for beginners will teach you HTML and how to create your website from the scratch. HTML isn't difficult, so hoping you will enjoy learning.</p>
        </article>
        <article>
            <header>
            <h2>Start Quiz "HTML Basic"</h2>
            <small>You can test your HTML skills with W3docs' Quiz.</small>
            </header>
            <p>You will get 5% for each correct answer for single choice questions. In multiple choice question it might be up to 5%. At the end of the Quiz, your total score will be displayed. Maximum score is 100%.</p>
        </article>
        </section>
        <aside>
        <h2>Our Books</h2>
        <p>HTML</p>
        <p>CSS</p>
        <p>JavaScript</p>
        <p>PHP</p>
        </aside>
        <footer>
        <small>Company © W3docs. All rights reserved.</small>
        </footer>
    </body>
    </html>
    HTML;
    $res->sendHTML($html);
});

$app->listen(function (Sparkle $app) {
    echo "http://{$app->getAddress()}:{$app->getPort()}" . PHP_EOL;
});