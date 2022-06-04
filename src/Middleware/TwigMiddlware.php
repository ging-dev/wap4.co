<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigMiddware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $loader = new FilesystemLoader(Utils::TEMPLATE_DIR);

        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        $twig->addExtension(new StringExtension());
        $twig->addExtension(new CustomDataExtension());
        $twig->addExtension(new Psr7Extension($request, new Response()));

        return $next($request->withAttribute('twig', $twig));
    }
}
