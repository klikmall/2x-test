<?php


print '<h3>Task 1</h3>
<pre>Napiši metodo, ki sprejme poljubno veliko matrico random integerjev od 1 do 10. 
Če je vrednost katerega od integerjev enaka 1, potem naj funkcija spremeni vse vrednosti v tej vrstici v "X".</pre>';


// Create a test matrix

// Define min,max number of row & columns to create our matrix
$rnd_rows = rand(3,15); // will define number of rows in matrix
$rnd_cols = rand(3,15); // will define number of columns in matrix
 

//
// Do not modify bellow this line
//

$matrix_arr = array(); // initialize our matrix array
$num_resulting_rows = 0; // how many rows will fit our criteria

for($i=1; $i<=$rnd_rows; $i++){
    $matrix_arr[$i] = array();
    for($j=1; $j<=$rnd_cols; $j++){
        $matrix_arr[$i][$j] = rand(1,10); // our possible values in matrix arr
    } // end for
} // end for

// See how matrix arr looks in a form of table
for($i=1; $i<=$rnd_rows; $i++){
    
    $bg_color = $i % 2 === 0 ? '#cccccc' : '#ffffff'; // alternate row bg color

    $matrix_rows .= '<tr style="background-color:'.$bg_color.';">';
    for($j=1; $j<=$rnd_cols; $j++){
        $matrix_rows .= '<td style="padding:5px; width:40px; text-align:center;">'.$matrix_arr[$i][$j].'</td>';
        // $matrix_rows .= '<td style="padding:5px; width:40px; text-align:center;">('.$i.'/'.$j.')<br>'.$matrix_arr[$i][$j].'</td>';  // with row/col mark
    } // end for
    $matrix_rows .= '</tr>';
} // end for

$matrix_table = '<table>'.$matrix_rows.'</table>';


print '<h3>MATRIX config</h3>';
print 'Num. of Rows: '.$rnd_rows.'<br>';
print 'Num. of Columns: '.$rnd_cols.'<br>';
print '<h3>Matrix as table</h3>';
print $matrix_table;

// Solving a TEST 
$test_matrix_rows = '';
$print_rows_with_1 = ''; // print rows' number where we found 1

for($i=1; $i<=$rnd_rows; $i++){
    
    $curr_row_has_1 = false;

    if( in_array(1, $matrix_arr[$i])){
        // we have at least one 1 in our row -> redefine whole row values to X
        /*
        Here we could use multiple solutions to check current row, but in_array() is among the fastest
        Other options:
        1) array_unique($matrix_arr[$i]) -> test if in_array on an array of max. 10 elements
        2) sort($matrix_arr[$i]) -> since array can have only integers 1-10, if( $matrix_arr[$i][0]!=1) then this row does not have 1 in it.
        3) array_search is also an option as in_array, but since be only need true/false, in_array is more suitable, with very similar & optimal performance 
        */
        $num_resulting_rows++;
        $curr_row_has_1 = true;
        
        // Process display results
        $print_rows_with_1 .= 'Found value 1 in row Num. <b>'.$i.'</b><br>';
        $print_rows_with_1 .= 'Before changing rows values: <pre>'.print_r($matrix_arr[$i], true).'</pre>';
        $matrix_arr[$i] = markAllAsX($matrix_arr[$i], $rnd_cols); // change row values to X
        $print_rows_with_1 .= 'After: <pre>'.print_r($matrix_arr[$i], true).'</pre>';
        $print_rows_with_1 .= '<hr>';

    } else {
        $print_rows_with_1 .= 'Row <b>'.$i.'</b> does not contain 1<hr>';
    }

    $test_matrix_rows .= '<tr>';
    for($j=1; $j<=$rnd_cols; $j++){
        $test_matrix_rows .= '<td style="padding:5px; width:40px; text-align:center;">'.$matrix_arr[$i][$j].'</td>';
    } // end for
    $test_matrix_rows .= '</tr>';
} // end for

// set matrix as table
$test_matrix_table = '<table>'.$test_matrix_rows.'</table>';

print '<h3>Matrix RESULT as table</h3>
<p style="font-weight:bold;">('.$num_resulting_rows.'/'.$rnd_rows.') rows match our criteria</p>'.
$test_matrix_table.
'
<br>
<br>
<br>
<h3>Process results</h3>
<p>'.$print_rows_with_1.'</p>';


// change all array values to X
function markAllAsX($arr, $arrNumElements){  
    
    /* 
    We could also have this function without a 2nd argument "$arrNumElements" and do a count() at this point.
    Passing number of cols since we already have it known at the point of calling this function 
    improves performance, but increases complexity of code 
    as it would be cleaner to pass only arr and have this function more generic
    */
    // $arrNumElements = count($arr);

    /* Also might be usable: a final check before creating a result array */
    /*
    if(!is_numeric($arrNumElements))){
        $arrNumElements = count($arr); // to be sure to have this value bellow in array_fill
    }
    */

    // just create a new array with all X-es and return it 
    // we start with 1 as are rows defined
    return array_fill(1, $arrNumElements, 'X');
}