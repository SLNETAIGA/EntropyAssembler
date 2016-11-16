// Usage: php7 easm.php input.asm

<?php
function float_rand ($min,$max) {
   return ($min+lcg_value()*(abs($max-$min)));
}

function mutateint($it){
$c = rand(1,20);
if($c==4){
$r = float_rand(1,2);
$it-=$r;
}else{
$r = float_rand(1,2);
$it+=$r;
}
return $it;
}

$source = file_get_contents($argv[1]);
$source = explode(" ",$source);
$source = preg_replace("/\;.+?\n/", "", $source,-1);

$l = array();
$stack = array();
for($i=0;$i<9;$i++){
	$stack[$i] = 0;
}

for($i=0; $i<count($source); ++$i){
	if(trim($source[$i]) == "INC"){
		$stack[trim($source[$i+=1])]++;
	} else if(trim($source[$i]) == "DEC"){
		$stack[trim($source[$i+=1])]--;
	} else if(trim($source[$i]) == "ADD"){
		$stack[trim($source[$i+=1])]+=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "SUB"){
		$stack[trim($source[$i+=1])]-=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "ADD"){
		$stack[trim($source[$i+=1])]+=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "MUL"){
		$stack[trim($source[$i+=1])]*=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "DIV"){
		$stack[trim($source[$i+=1])]/=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "MOD"){
		$stack[trim($source[$i+=1])]%=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "MOV"){
		$stack[trim($source[$i+=1])]=$stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "SET"){
		$stack[trim($source[$i+=1])]=(int) trim($source[$i+=1]);
	} else if(trim($source[$i]) == "OUT"){
		echo chr($stack[trim($source[$i+=1])]);
	} else if(trim($source[$i]) == "PUT"){
		echo $stack[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "LABEL"){
		$l[trim($source[$i+=1])] = $i;
	} else if(trim($source[$i]) == "GOTO"){
		$i = $l[trim($source[$i+=1])];
	} else if(trim($source[$i]) == "IN"){
		$stack[trim($source[$i+=1])] = ord(fgets(STDIN));
	} else if(trim($source[$i]) == "IFEQ"){
		if($stack[trim($source[$i+=1])] == $stack[trim($source[$i+=1])]){
			$i = trim($source[$i+=1]);
		} else {
			$i = trim($source[$i+=1]);
		}
	} else if(trim($source[$i]) == "IFZERO"){
		if($stack[trim($source[$i+=1])] == 0){
			$i = trim($source[$i+=1]);
		} else {
			$i = trim($source[$i+=1]);
		}
	} else if(trim($source[$i]) == "IFLT"){
		if($stack[trim($source[$i+=1])] < $stack[trim($source[$i+=1])]){
			$i = trim($source[$i+=1]);
		} else {
			$i = trim($source[$i+=1]);
		}
	} else if(trim($source[$i]) == "TEST"){
		if($stack[trim($source[$i+=1])]){
			$i = trim($source[$i+=1]);
		} else {
			$i = trim($source[$i+=1]);
		}
	} 
	
	foreach($stack as $k=>$v){
		$c = rand(1,rand(0,7));
		if($c==4){
	    $stack[$k] = mutateint($stack[$k]);
		}
	}
}
