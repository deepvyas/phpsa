<?php

namespace PHPSA\Analyzer\Pass\Statement;

use PhpParser\Node;
use PhpParser\Node\Stmt\For_;
use PHPSA\Analyzer\Helper\DefaultMetadataPassTrait;
use PHPSA\Analyzer\Pass;
use PHPSA\Context;

class ForLoopMultiple implements Pass\AnalyzerPassInterface
{
    use DefaultMetadataPassTrait;

    /**
     * @param Property $prop
     * @param Context $context
     * @return bool
     */
    public function pass($stmt, Context $context)
    {
        if ($stmt instanceof For_ && count($stmt->cond) > 1) {
            $context->notice(
                'for_loop_multiple',
                'Number of conditions in for larger than one.Merge them using && symbol.',
                $stmt
            );
            return true;
        }
        return false;
    }
    /**
     * @return array
     */
    public function getRegister()
    {
        return [
            For_::class,
        ];
    }
}
