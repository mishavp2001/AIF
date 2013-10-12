<?php
function exportNestedSimpleXML($data) {
    if (is_scalar($data) === false) {
        foreach ($data as $k => $v) {
            if ($v instanceof SimpleXMLElement) {
                $v = str_replace("&#13;","\r",$v->asXML());
            } else {
                $v = exportNestedSimpleXML($v);
            }

            if (is_array($data)) {
                $data[$k] = $v;
            } else if (is_object($data)) {
                $data->$k = $v;
            }
        }
    }

    return $data;
}

$data = array (
    "baz" => array (
        "foo" => new stdClass(),
        "int" => 123,
        "str" => "asdf",
        "bar" => new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><foo>bar</foo>'),
    )
);

var_dump($data);
/*array(1) {
  ["baz"]=>
  array(4) {
    ["foo"]=>
    object(stdClass)#3 (0) {
    }
    ["int"]=>
    int(123)
    ["str"]=>
    string(4) "asdf"
    ["bar"]=>
    object(SimpleXMLElement)#4 (1) {
      [0]=>
      string(3) "bar"
    }
  }
}*/

var_dump(exportNestedSimpleXML($data));
/*array(1) {
  ["baz"]=>
  array(4) {
    ["foo"]=>
    object(stdClass)#3 (0) {
    }
    ["int"]=>
    int(123)
    ["str"]=>
    string(4) "asdf"
    ["bar"]=>
    string(54) "<?xml version="1.0" encoding="UTF-8"?>
<foo>bar</foo>
"
  }
}




array(1)
 {
	["baz"]=> array(4) 
	{ 
		["foo"]=> object(stdClass)#1 (0) { } 
		["int"]=> int(123) 
		["str"]=> string(4) "asdf" 
		["bar"]=> object(SimpleXMLElement)#2 (1) { [0]=> string(3) "bar" }
	} 
}

array(1) 
{ 
	["baz"]=> array(4) 
	{ 
		["foo"]=> object(stdClass)#1 (0) { }
		["int"]=> int(123)
		["str"]=> string(4) "asdf" 
		["bar"]=> string(54) " bar " 
	}
} 



*/
?>