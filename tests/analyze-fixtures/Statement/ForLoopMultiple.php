<?php

namespace Tests\Analyze\Fixtures\Statement;

class ForLoopMultiple
{
    public function testForLoopMultiple()
    {
        for($i=0, $j=0; $i<3, $j<2;$i++,$j++){
            echo "test"; // 2 times
        }
    }

    public function testNoFroLoopMultiple()
    {
        for($i=0; $i<3;$i++){
            echo "test"; // 2 times
        }
    }
}
?>
----------------------------
[
    {
        "type": "for_loop_multiple",
        "message": "Number of conditions in for larger than one.Merge them using && symbol",
        "file": "ForLoopMultiple.php",
        "line": 8
    }
]