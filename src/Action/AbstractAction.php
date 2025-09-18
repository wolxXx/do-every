<?php

declare(strict_types=1);

namespace DoEveryApp\Action;

abstract class AbstractAction
{
    protected \Psr\Http\Message\ServerRequestInterface $request;

    protected \Psr\Http\Message\ResponseInterface      $response;

    protected mixed                                    $args;

    protected \DoEveryApp\Util\ErrorStore              $errorStore;

    protected \DoEveryApp\Util\DependencyContainer     $dependencyContainer;

    protected \Doctrine\ORM\EntityManager              $entityManager;

    protected \DoEveryApp\Util\Translator              $translator;

    final public function __construct()
    {
        \DoEveryApp\Util\Session::Factory(namespace: \DoEveryApp\Util\Session::NAMESPACE_APPLICATION);
        new \DoEveryApp\Util\SessionContainer(name: \DoEveryApp\Util\Session::NAMESPACE_APPLICATION);
        $this->errorStore          = new \DoEveryApp\Util\ErrorStore();
        $this->dependencyContainer = \DoEveryApp\Util\DependencyContainer::getInstance();
        $this->entityManager       = $this->dependencyContainer->getEntityManager();
        $this->translator          = $this->dependencyContainer->getTranslator();
    }

    public function getRequest(): \Psr\Http\Message\ServerRequestInterface
    {
        return $this->request;
    }

    public function setRequest(\Psr\Http\Message\ServerRequestInterface $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getResponse(): \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }

    public function setResponse(\Psr\Http\Message\ResponseInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getErrorStore(): \DoEveryApp\Util\ErrorStore
    {
        return $this->errorStore;
    }

    final public function direct(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, mixed $arguments): \Psr\Http\Message\ResponseInterface
    {
        return $this
            ->setRequest(request: $request)
            ->setResponse(response: $response)
            ->setArgs(args: $arguments)
            ->init()
            ->appendHeaders()
            ->getResponse()
        ;
    }

    private function appendHeaders(): static
    {
        header(header: "Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header(header: "Cache-Control: post-check=0, pre-check=0", replace: false);
        header(header: "Pragma: no-cache");
        $response = $this->getResponse();
        $response = $response->withHeader(name: 'Cache-Control', value: 'no-store, no-cache, must-revalidate, max-age=0');
        $response = $response->withAddedHeader(name: 'Cache-Control', value: 'post-check=0, pre-check=0');
        $response = $response->withAddedHeader(name: 'Pragma', value: 'no-cache');

        return $this->setResponse(response: $response);
    }

    final public function init(): static
    {
        $annotation = new \ReflectionClass(objectOrClass: $this);
        $attributes = $annotation->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class);
        if (0 === count(value: $attributes)) {
            throw new \InvalidArgumentException(message: 'no route attribute detected!');
        }
        foreach ($attributes as $attribute) {
            /**
             * @var \DoEveryApp\Attribute\Action\Route $attributeX
             */
            $attributeX = $attribute->newInstance();
            if (true === $attributeX->authRequired && false === \DoEveryApp\Util\User\Current::isAuthenticated()) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->loginRequired());
                $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());

                return $this;
            }
        }

        $this->run();

        return $this;
    }

    abstract public function run(): \Psr\Http\Message\ResponseInterface;

    protected function prepare(): static
    {
        return $this;
    }

    protected function getReferrer(): ?string
    {
        return $this
            ->getRequest()
            ->getHeaderLine(name: 'referer')
        ;
    }

    protected function redirect(string $to): \Psr\Http\Message\ResponseInterface
    {
        $this->setResponse(
            response: $this
                ->getResponse()
                ->withHeader(name: 'Location', value: $to)
                ->withStatus(code: 302)
        );

        return $this->getResponse();
    }

    /**
     * @param array<mixed> $data
     */
    protected function render(string $script, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        $defaultVariables = [
            'errorStore'          => $this->getErrorStore(),
            'currentRoute'        => \Slim\Routing\RouteContext::fromRequest(serverRequest: $this->getRequest())->getRoutingResults()->getUri(),
            'currentRoutePattern' => static::getRoutePattern(),
            'currentUser'         => \DoEveryApp\Util\User\Current::get(),
            'translator'          => $this->translator,
        ];

        $phpRenderer = \DoEveryApp\Util\DependencyContainer::getInstance()
                                                           ->getRenderer()
        ;
        $phpRenderer->setAttributes(attributes: $defaultVariables);

        return $phpRenderer
            ->render(response: $this->getResponse(), template: $script . '.php', data: \array_merge($defaultVariables, $data))
        ;
    }

    public static function getRoutePattern(): string
    {
        $reflection = new \ReflectionClass(objectOrClass: static::class);
        $route      = $reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class)[0];

        return $route
            ->newInstance()
            ->path;
    }

    public function getArgs(): mixed
    {
        return $this->args;
    }

    public function setArgs(mixed $args): static
    {
        $this->args = $args;

        return $this;
    }

    public function getFromQuery(string $key, mixed $default = null): mixed
    {
        return $this->getRequest()->getQueryParams()[$key] ?? $default;
    }

    public function getFromBody(string $key, mixed $default = null): mixed
    {
        $body = $this->getRequest()->getParsedBody();
        if (null === $body) {
            return $default;
        }
        if (true === \is_array(value: $body)) {
            if (true === \array_key_exists(key: $key, array: $body)) {
                return $body[$key];
            }

            return $default;
        }
        if (true === \property_exists(object_or_class: $body, property: $key)) {
            return $body->{$key};
        }

        return $default;
    }

    public function getArgumentSafe(string $argumentName = 'id'): mixed
    {
        if (false === array_key_exists(key: $argumentName, array: $this->args)) {
            throw new \DoEveryApp\Exception\ArgumentNoSet(message: 'Argument ' . $argumentName . ' is missing but needed');
        }

        return $this->args[$argumentName];
    }

    protected function isGetRequest(): bool
    {
        return \Fig\Http\Message\RequestMethodInterface::METHOD_GET === $this->request->getMethod();
    }

    protected function isPostRequest(): bool
    {
        return \Fig\Http\Message\RequestMethodInterface::METHOD_POST === $this->request->getMethod();
    }

    protected function isAjaxRequest(): bool
    {
        return 'XMLHttpRequest' === $this->getRequest()->getHeaderLine(name: 'X-Requested-With');
    }

    protected function validate(array $data, \Symfony\Component\Validator\Constraints\Collection $validators): static
    {
        $validator = \DoEveryApp\Util\DependencyContainer::getInstance()->getValidator();
        $hasErrors = false;
        foreach ($validator->validate(value: $data, constraints: $validators) as $error) {
            $key     = $error->getPropertyPath();
            $key     = \substr(string: $key, offset: 1, length: strlen(string: $key) - 2);
            $message = $error->getMessage();
            $this
                ->getErrorStore()
                ->addError(key: $key, message: $message)
            ;
            $hasErrors = true;
        }

        if (true === $hasErrors) {
            throw new \DoEveryApp\Exception\FormValidationFailed(message: 'errors detected: ' . \json_encode(value: $this->getErrorStore()->getAllErrors()));
        }

        return $this;
    }
}
