<?php

namespace PHPSA\Compiler;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PhpParser\Node;
use PHPSA\Compiler;
use RuntimeException;
use Webiny\Component\EventManager\EventManager;

class Scalar
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @param Context $context
     * @param EventManager $eventManager
     */
    public function __construct(Context $context, EventManager $eventManager)
    {
        $this->context = $context;
        $this->eventManager = $eventManager;
    }

    /**
     * @param Node\Scalar $scalar
     * @return CompiledExpression
     */
    public function compile(Node\Scalar $scalar)
    {
        try {
            $this->eventManager->fire(
                Event\ScalarBeforeCompile::EVENT_NAME,
                new Event\ScalarBeforeCompile(
                    $scalar,
                    $this->context
                )
            );

            return $this->factory($scalar);
        } catch (\Exception $e) {
            $this->context->debug('ScalarCompiler is not implemented for ' . get_class($scalar));
        }
    }

    /**
     * @param Node\Scalar $scalar
     * @return CompiledExpression
     * @throws RuntimeException
     */
    protected function factory(Node\Scalar $scalar)
    {
        switch (get_class($scalar)) {
            case \PHPSA\Node\Scalar\Nil::class:
                return new CompiledExpression(CompiledExpression::NULL);
            case \PHPSA\Node\Scalar\Boolean::class:
                return new CompiledExpression(CompiledExpression::BOOLEAN, $scalar->value);
            case \PHPSA\Node\Scalar\Fake::class:
                return new CompiledExpression($scalar->type, $scalar->value);

            /**
             * Numbers
             */
            case Node\Scalar\MagicConst\Line::class:
            case Node\Scalar\LNumber::class:
                return new CompiledExpression(CompiledExpression::INTEGER, $scalar->value);
            case Node\Scalar\DNumber::class:
                return new CompiledExpression(CompiledExpression::DOUBLE, $scalar->value);

            /**
             * Strings
             */
            case Node\Scalar\String_::class:
            case Node\Scalar\EncapsedStringPart::class:
            case Node\Scalar\Encapsed::class:
            case Node\Scalar\MagicConst\Trait_::class:
            case Node\Scalar\MagicConst\Namespace_::class:
            case Node\Scalar\MagicConst\Class_::class:
            case Node\Scalar\MagicConst\Dir::class:
            case Node\Scalar\MagicConst\File::class:
            case Node\Scalar\MagicConst\Function_::class:
            case Node\Scalar\MagicConst\Method::class:
                return new CompiledExpression(CompiledExpression::STRING, $scalar->value);

            default:
                throw new RuntimeException('Unknown scalar: ' . get_class($scalar));
        }
    }
}
