<?php

/*
Author dwi.setiyadi@gmail.com
Made for Sirclo
*/

/* config */
$value_a_max = 4;
$value_b_max = 6;

$col_a = 2;
$col_b_max = 5;
$row = 5;
/* end of config */

$a_block = array();
$b_block = array();

// collect a block
for ($ir=1; $ir<=$row; $ir++) {
    $member = '';
    
    for ($ic=1; $ic<=$col_a; $ic++) {
        $member .= $value_a_max;
    }
    array_push($a_block, $member);
    
    $value_a_max = $value_a_max - 1;
    unset($member);
}

// collect b block
for ($ir=1; $ir<=$row; $ir++) {
    $member = '';
    
    if ($ir > 1) $col_b_max = $col_b_max - 1;
    for ($ic=1; $ic<=$col_b_max; $ic++) {
        $member .= $value_b_max;
    }
    array_push($b_block, $member);
    
    $value_b_max = $value_b_max - 1;
    unset($member);
}

// print combined a block and b block
foreach ($a_block as $key => $value) {
    echo $value . $b_block[$key] . '<br>';
}

/* end of file */