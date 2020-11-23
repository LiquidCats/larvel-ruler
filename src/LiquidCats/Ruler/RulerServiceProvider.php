<?php

declare(strict_types=1);

namespace LiquidCats\Ruler;

use Hoa\Ruler\Ruler;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use LiquidCats\Ruler\Context\Variables;
use LiquidCats\Ruler\Assertions\Asserter;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use LiquidCats\Ruler\Context\ContextProvider;
use LiquidCats\Ruler\Contracts\CacherContract;
use LiquidCats\Ruler\Contracts\CompilerContract;
use LiquidCats\Ruler\Contracts\EnforcerContract;
use LiquidCats\Ruler\Contracts\AuthorizerContract;
use LiquidCats\Ruler\Contracts\Context\ContextProviderContract;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

/**
 * Class RulerServiceProvider.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 *
 * @property Container $app
 */
class RulerServiceProvider extends RouteServiceProvider
{
    public function register(): void
    {
        self::registerRuler($this->app);
        self::registerVariables($this->app);

        $this->app->singleton(ContextProviderContract::class, ContextProvider::class);

        $this->app->singleton(CacherContract::class, Cacher::class);
        $this->app->singleton(CompilerContract::class, Compiler::class);
        $this->app->singleton(EnforcerContract::class, Enforcer::class);
        $this->app->singleton(AuthorizerContract::class, Authorizer::class);
    }

    protected static function registerRuler(Container $app): void
    {
        $app->singleton(Asserter::class, static function (Container $app) {
            $logger = $app[LoggerInterface::class];
            $config = $app[Repository::class];

            $asserter = new Asserter($logger);

            $operators = $config->get('security.operators', []);

            foreach ($operators as $operatorClass) {
                /** @var Operators\AbstractOperator $operator */
                $operator = $app[$operatorClass];
                $asserter->setOperator(Str::lower($operator->getName()), $operator->getOperator());
            }

            return $asserter;
        });
        $app->singleton(Ruler::class, static function (Container $app) {
            $ruler = new Ruler();
            $ruler->setAsserter($app[Asserter::class]);

            return $ruler;
        });
    }

    protected static function registerVariables(Container $app): void
    {
        $app->singleton(Variables\Source::class, fn (Container $app) => Variables\Source::build($app[Request::class]));
        $app->singleton(Variables\Internals::class, static function (Container $app) {
            $internals = new Variables\Internals();

            $config = $app[Repository::class];
            $resolvers = $config->get('security.resolvers', []);

            foreach ($resolvers as $resolverClass) {
                $resolver = $app[$resolverClass];
                $internals->setParameter($resolver);
            }

            return $internals;
        });
        $app->singleton(Variables\Env::class);
    }
}
