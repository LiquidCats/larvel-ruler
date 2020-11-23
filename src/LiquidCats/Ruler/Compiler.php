<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use Hoa\Ruler\Ruler;
use Psr\Log\LoggerInterface;
use LiquidCats\Ruler\Decisions\Consensus;
use LiquidCats\Ruler\Decisions\Unanimous;
use LiquidCats\Ruler\Decisions\Affirmative;
use LiquidCats\Ruler\Context\SecurityContext;
use LiquidCats\Ruler\Contracts\CacherContract;
use LiquidCats\Ruler\Contracts\CompilerContract;
use LiquidCats\Ruler\Contracts\Rules\RuleContract;
use Illuminate\Contracts\Cache\Repository as CacheRepo;
use LiquidCats\Ruler\Contracts\Rules\PermissionContract;

/**
 * Class Compiler.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 */
class Compiler implements CompilerContract
{
    protected Ruler $ruler;
    protected LoggerInterface $logger;
    protected CacheRepo $cache;
    protected CacherContract $cacher;

    public function __construct(LoggerInterface $logger, Ruler $ruler, CacherContract $cacher)
    {
        $this->ruler = $ruler;
        $this->logger = $logger;
        $this->cacher = $cacher;
    }

    public function compile(PermissionContract $permission, SecurityContext $context): bool
    {
        $this->logger->debug(sprintf('[SECURITY.compiler] Asserting permission [%s]', $permission->getName()), $context->toArray());
        if ($this->cacher->has($context, $permission)) {
            $result = $this->cacher->get($context, $permission);

            $this->logger->debug(
                sprintf('[SECURITY.compiler] Permission [%s] was restored from cache with result [%d]', $permission->getName(), (int) $result)
            );

            return $result;
        }
        $strategy = $permission->getStrategy();
        $rules = $permission->getRules();
        $decisions = $this->getDecisions($rules, $context);

        $result = false;
        if (Affirmative::shouldRun($strategy)) {
            $result = Affirmative::process($decisions);
        }
        if (Consensus::shouldRun($strategy)) {
            $result = Consensus::process($decisions);
        }
        if (Unanimous::shouldRun($strategy)) {
            $result = Unanimous::process($decisions);
        }

        $this->cacher->put($result, $context, $permission);

        $this->logger->debug(
            sprintf('[SECURITY.compiler] Permission [%s] has result [%d]', $permission->getName(), (int) $result)
        );

        return $result;
    }

    /**
     * @param RuleContract[] $rules
     * @return iterable
     */
    protected function getDecisions(iterable $rules, SecurityContext $context): iterable
    {
        foreach ($rules as $rule) {
            $decision = $this->ruler->assert($rule->getDefinition(), $context);
            $this->logger->debug(sprintf('[SECURITY.compiler] Rule asserted [%s] with decision [%d]', $rule->getName(), (int) $decision));
            yield $decision;
        }
    }
}
