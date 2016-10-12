<?php

namespace Tests\Analyze\Fixtures\Statement;

class PropertyDefinitionDefaultValue
{
    public function testDeafultValue()
    {
        $a= null;
    }

    public function testNoDefaultValue()
    {
        $a;
    }
}
?>
----------------------------
[
    {
        "type": "prop_definition_default_value",
        "message": "null is default and is not needed.",
        "file": "PropertyDefinitionDefalutValue.php",
        "line": 9
    }
]
