<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
		<script>
			var myArray = new Array("item1", "item");
		</script>
    </head>
    <body>
        <?php
        
        //Defining arrays
        //Array keys can be integers, strings, or both
        
        //String keys
        $stringKeyArray = Array(
            'key1' => 'item1',
            'key2' => 'item2',
            );
        
        echo '<h3>String Key Array - Output</h3>';
        echo $stringKeyArray['key1'];
        echo '<br>';
        echo $stringKeyArray['key2'];
        echo '<br>';
        echo var_dump($stringKeyArray);
              
        //Integer Keys        
        
        $integerKeyArray = Array(
            0 => 'item1',
            1 => 'item2',
            3 => 'item3',
            );
        echo '<h3>Integer Key Array - Output</h3>';
        echo $integerKeyArray[0];
        echo '<br>';
        echo $integerKeyArray[1];
        echo '<br>';
        echo $integerKeyArray[2];
        echo '<br>';
        echo $integerKeyArray[3];
        
        $mixedKeyArray = Array(
            'key1' => 'item1',
            'key2' => 'item2',
            2 => 'item3',
            4 => 'item4',
            "5" => 'item5', //String keys containin valid integers will be cast to integer type
			
            3.14159 => 'item 6', //Keys containing doubles will have the decimal part truncated.
            
			true => 'item7', //Keys containing boolean will be cast to integer (false=0, true=1)
            
			2 => 'item8' //A duplicate key will overwrite all previous instances of that key.*/
        );
        
        echo '<h3> Mixed Key Array - Output</h3>';
        foreach($mixedKeyArray as $key => $element){
            echo 'key: ' . $key . ', value: ' . $element . ', key data type: ' . gettype($key);
            echo '<br>';
        }
        
        echo '<h3>var_dump - Mixed Key Array</h3>';
        //echo var_dump($mixedKeyArray);
        
        
        //No Key Array
        $array1 = Array(1, 2);
		$array2 = Array(3, 4)
		$multiArray = Array($array1, $array2);
        $noKeyArray = Array(
		1, 2, 6=>3, 4);
        
        echo var_dump($noKeyArray);
        ?>
    </body>
</html>
