<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Yiisoft\Cookies\Cookie;

class Psr7Extension extends AbstractExtension
{
    private ServerRequestInterface $request;

    private ResponseInterface $response;

    public function __construct(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_get', [$this, 'get_get']),
            new TwigFunction('get_post', [$this, 'get_post']),
            new TwigFunction('request_method', [$this, 'request_method']),
            new TwigFunction('user_agent', [$this, 'user_agent']),
            new TwigFunction('ip', [$this, 'ip']),
            new TwigFunction('get_uri_segments', [$this, 'get_uri_segments']),
            new TwigFunction('redirect', [$this, 'redirect']),
            new TwigFunction('get_cookie', [$this, 'get_cookie']),
            new TwigFunction('set_cookie', [$this, 'set_cookie']),
            new TwigFunction('delete_cookie', [$this, 'delete_cookie']),
        ];
    }

    public function getReponse(): ResponseInterface
    {
        return $this->response;
    }

    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function get_get(string $name): string
    {
        return $this->request->getQueryParams()[$name] ?? '';
    }

    public function get_post(string $name): string
    {
        return $this->request->getParsedBody()[$name] ?? '';
    }

    public function user_agent(): string
    {
        return $this->request->getHeaderLine('User-Agent');
    }

    public function ip(): string
    {
        return $this->request->getServerParams()['REMOTE_ADDR'] ?? '';
    }

    public function request_method(): string
    {
        return $this->request->getMethod();
    }

    public function get_uri_segments(): array
    {
        return explode('/', rtrim($this->request->getAttribute('uri', 'index'), '/'));
    }

    public function redirect(string $uri): void
    {
        $response = $this->getReponse()
            ->withStatus(Response::STATUS_FOUND)
            ->withHeader('Location', $uri);

        $this->setResponse($response);
    }

    public function set_cookie(string $name, string $value): void
    {
        $response = (new Cookie($name, $value))
            ->withPath('/')
            ->withExpires(new \DateTime('+1 year'))
            ->addToResponse($this->getReponse());

        $this->setResponse($response);
    }

    public function delete_cookie(string $name): void
    {
        $response = (new Cookie($name))->expire()->addToResponse($this->getReponse());

        $this->setResponse($response);
    }

    public function get_cookie(string $name): string
    {
        return $this->request->getCookieParams()[$name] ?? '';
    }
}
