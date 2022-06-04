<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Io\BufferedBody;
use Twig\Environment;

class TwigController
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Environment */
        $twig = $request->getAttribute('twig');
        $ext = $twig->getExtension(Psr7Extension::class);

        ob_start();
        try {
            $filename = Utils::getFile(current($ext->get_uri_segments()));
            echo $twig->render($filename);
        } catch (Error $e) {
            echo rtrim($e->getMessage(), '.').' in "'.basename($e->getFile()).'" at line '.$e->getLine();
        }

        return $ext->getReponse()->withBody(new BufferedBody(ob_get_clean()));
    }
}
