<?php

/*
Testing multiple solutions for checking for na item in a arrray
 */

print '<h3>Task 1 Final Result</h3>
<pre>Napiši metodo, ki sprejme poljubno veliko matrico random integerjev od 1 do 10.
Če je vrednost katerega od integerjev enaka 1, potem naj funkcija spremeni vse vrednosti v tej vrstici v "X".</pre>';

// Create a test matrix

// Define min,max number of row & columns to create our matrix
$rnd_rows = rand(3, 15); // will define number of rows in matrix
$rnd_cols = rand(3, 15); // will define number of columns in matrix

//
// Do not modify bellow this line
//

$matrix_arr = array(); // initialize our matrix array

for ($i = 1; $i <= $rnd_rows; $i++) {
    $matrix_arr[$i] = array();
    for ($j = 1; $j <= $rnd_cols; $j++) {
        $matrix_arr[$i][$j] = rand(1, 10); // our possible values in matrix arr
    } // end for
} // end for

// Solving a TEST
$test_matrix_rows = '';

for ($i = 1; $i <= $rnd_rows; $i++) {

    if (in_array(1, $matrix_arr[$i])) {
        $matrix_arr[$i] = markAllAsX($matrix_arr[$i], $rnd_cols); // change row values to X
    }

    $test_matrix_rows .= '<tr>';
    for ($j = 1; $j <= $rnd_cols; $j++) {
        $test_matrix_rows .= '<td style="padding:5px; width:40px; text-align:center;">' . $matrix_arr[$i][$j] . '</td>';
    } // end for
    $test_matrix_rows .= '</tr>';
} // end for

// set matrix as table
$test_matrix_table = '<table>' . $test_matrix_rows . '</table>';

print '<h3>RESULT as table</h3>' . $test_matrix_table;

// change all array values to X
function markAllAsX($arr, $arrNumElements)
{
    return array_fill(1, $arrNumElements, 'X');
}
