<?php

namespace Tests\Analyze\Fixtures\Statement;

class PropertyDefinitionDefaultValue
{
    public $a = null;
}

class PropetyDefinitionNoDefaultValue
{
    public $a;
}

?>
----------------------------
[
    {
        "type": "property_definition_default_value",
        "message": "null is default and is not needed.",
        "file": "PropertyDefinitionDefaultValue.php",
        "line": 6
    }
]