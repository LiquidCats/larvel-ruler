<?php

declare(strict_types=1);

namespace LiquidCats\Ruler\Assertions;

use Exception;
use Hoa\Ruler;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;
use Hoa\Ruler\Model\Bag\Context as BagContext;
use Hoa\Ruler\Visitor\Asserter as VendorAsserter;

/**
 * Class VisitorAssert.
 *
 * @author Ilya Shabanov i.s.shabanov@ya.ru
 * @mixin Asserter
 */
class Asserter extends VendorAsserter
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, Ruler\Context $context = null)
    {
        parent::__construct($context);
        $this->logger = $logger;
    }

    protected function visitAttributeDimension(
        &$contextPointer,
        array $dimension,
        $dimensionNumber,
        $elementId,
        &$handle = null,
        $eldnah = null
    ): void {
        $attribute = $dimension[BagContext::ACCESS_VALUE];

        try {
            $contextPointer = $contextPointer->{$attribute};
        } catch (Exception $e) {
            $contextPointer = 0;
            // if it's not an object and there is no attribute just set it to null
            $this->logger->warning(
                sprintf(
                    'Try to read an undefined attribute: %s (dimension number %d of %s), because it is not an object. Additional information: %s',
                    $attribute,
                    $dimensionNumber,
                    $elementId,
                    $e->getMessage()
                )
            );
        }
    }
}
