<?php

/*
Testing multiple solutions for checking for na item in a arrray
 */

class matrixClass
{   
    
    public function matrixFunction($matrix_arr)
    {
        // Solving a TEST
        $test_matrix_rows = '';

        $rnd_rows = count($matrix_arr);
        $rnd_cols = count($matrix_arr[1]);

        # print '<pre>'.$rnd_rows.' - '.$rnd_cols.'</pre>';

        for ($i = 1; $i <= $rnd_rows; $i++) {

            if (in_array(1, $matrix_arr[$i])) {
                $matrix_arr[$i] = $this->markAllAsX($matrix_arr[$i], $rnd_cols); // change row values to X
            }

            $test_matrix_rows .= '<tr>';
            for ($j = 1; $j <= $rnd_cols; $j++) {
                $test_matrix_rows .= '<td style="padding:5px; width:40px; text-align:center;">' . $matrix_arr[$i][$j] . '</td>';
            } // end for
            $test_matrix_rows .= '</tr>';
        } // end for

        // set matrix as table
        $test_matrix_table = '<table>' . $test_matrix_rows . '</table>';

        return $test_matrix_table;
    }


    private function markAllAsX($arr)
    {
        $arrNumElements = count($arr);
        return array_fill(1, $arrNumElements, 'X');
    }

} 

// Create a test matrix

// Define min,max number of row & columns to create our matrix
$rnd_rows = rand(3, 15); // will define number of rows in matrix
$rnd_cols = rand(3, 15); // will define number of columns in matrix

$matrix_arr = array(); // initialize our matrix array

for ($i = 1; $i <= $rnd_rows; $i++) {
    $matrix_arr[$i] = array();
    for ($j = 1; $j <= $rnd_cols; $j++) {
        $matrix_arr[$i][$j] = rand(1, 10); // our possible values in matrix arr
    } // end for
} // end for

# print '<h3>matrix_arr</h3><pre>' . print_r($matrix_arr, true) . '</pre>';

$matrixClass = new matrixClass;
# Print result
print '<h3>RESULT as table</h3>' . $matrixClass->matrixFunction($matrix_arr);
