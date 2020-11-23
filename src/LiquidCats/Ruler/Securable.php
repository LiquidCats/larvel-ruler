<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use LiquidCats\Ruler\Context\ContextualAction;
use Illuminate\Validation\UnauthorizedException;
use LiquidCats\Ruler\Contracts\AuthorizerContract;

/**
 * Class Securable.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
trait Securable
{
    public function authorizeIndex(): void
    {
        $this->authorizeFor(ContextualAction::INDEX);
    }

    public function authorizeShow(): void
    {
        $this->authorizeFor(ContextualAction::SHOW);
    }

    public function authorizeUpdate(): void
    {
        $this->authorizeFor(ContextualAction::UPDATE);
    }

    public function authorizeCreate(): void
    {
        $this->authorizeFor(ContextualAction::CREATE);
    }

    public function authorizeDelete(): void
    {
        $this->authorizeFor(ContextualAction::DELETE);
    }

    protected function throwUnauthorizedIfNegativeDecision(bool $decision): void
    {
        if (!$decision) {
            throw new UnauthorizedException('Not Allowed');
        }
    }

    protected function resolveResource(): string
    {
        if (property_exists($this, 'contextResource')) {
            return $this->contextResource;
        }
        if (method_exists($this, 'getContextResource')) {
            return $this->getContextResource();
        }
        if (defined(self::class.'::CONTEXT_RESOURCE')) {
            return self::CONTEXT_RESOURCE;
        }

        return 'default';
    }

    protected function authorizeFor(string $action): void
    {
        /** @var AuthorizerContract $authorizer */
        $authorizer = app(AuthorizerContract::class);
        $this->throwUnauthorizedIfNegativeDecision(
            $authorizer->authorise($this->resolveResource(), $action)
        );
    }
}
