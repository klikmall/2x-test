<?php

/*
Testing multiple solutions for checking for na item in a arrray
 */

$big_arr_num_elements = 10; // Number of random (1-10) integers put in our test array
// $big_arr_num_elements = 1000000; // Make an test array with 1 mio values

$big_arr_limit_display_num_elements = 30; // if $big_arr_num_elements > $big_arr_limit_display_num_elements, array values will not be displayed, only summary results

/*
For a small number of elements the type of chosen solution probably would not matter much.
But in case of 100000+ elements in big_arr, solutions take different amounts of time to complete the test and task to transform the  big_arr if test returns true
 */

//
// Do not modify bellow this line
//

$benchmark_points_arr = array(); // array with benchmarked points we will display

// Create "big" array
$big_arr = array();

// FILL big_arr with rand values from which we want to create tests if value 1 is in array
for ($i = 0; $i <= $big_arr_num_elements; $i++) {
    $big_arr[] = rand(1, 10);
} // end for

// Start Benchmark for Total Time
$startScriptTime = microtime(true);

// See big array values
# print '<pre>'.print_r($big_arr, true).'</pre>';

//
// Start SOLUTION 1
//
$result_str = ''; // var to display what the result of a check was
$result_arr = array(); // initialize result array
$startTime = microtime(true);

if (in_array(1, $big_arr)) {
    $result_arr = markAllAsX($big_arr); // we have 1 in big_arr, so change all values to X
    $result_str = 'true';
} else {
    $result_arr = $big_arr; // we do not have 1 in our big_arr, leave result_arr as big_arr
    $result_str = 'false';
}

$endTime = microtime(true);
$elapsed = ($endTime - $startTime) * 1000;
$benchmark_points_arr['solution-1'] = array(
    'time' => $elapsed,
    'result' => $result_str,
    'check_arr' => $big_arr,
    'result_arr' => $result_arr,
);
// end SOLUTION 1

//
// Start SOLUTION 2: use array_unique to minimize array values to be checked for test
//
$result_str = ''; // var to display what the result of a check was
$result_arr = array(); // initialize result array
$startTime = microtime(true);

$check_arr = array_unique($big_arr); // limit array for checking values to max. 10 elements

if (in_array(1, $check_arr)) {
    $result_arr = markAllAsX($big_arr); // we have 1 in big_arr, so change all values to X
    $result_str = 'true';
} else {
    $result_arr = $big_arr; // we do not have 1 in our big_arr, leave result_arr as big_arr
    $result_str = 'false';
}

$endTime = microtime(true);
$elapsed = ($endTime - $startTime) * 1000;
$benchmark_points_arr['solution-2'] = array(
    'time' => $elapsed,
    'result' => $result_str,
    'check_arr' => $check_arr,
    'result_arr' => $result_arr,
);
// end SOLUTION 2

//
// Start SOLUTION 3:
// First run a sort of big_arr (from lowest to highest)
// Now check element with key=0.
// If value 1 is in our big_arr, it will be present on asort($big_arr[0])
//
$result_str = ''; // var to display what the result of a check was
$result_arr = array(); // initialize result array
// initialize & empty result array
$check_arr = array();
unset($check_arr);
$startTime = microtime(true);

$check_arr = array_values($big_arr);
sort($check_arr); // limit array values to max. 1 (1-10)

if ($check_arr[0] == 1) {
    $result_arr = markAllAsX($big_arr); // we have 1 in big_arr, so change all values to X
    $result_str = 'true';
} else {
    $result_arr = $check_arr; // we do not have 1 in our big_arr, but display check_arr to be sure asort worked correctly
    $result_str = 'false';
}

$endTime = microtime(true);
$elapsed = ($endTime - $startTime) * 1000;
$benchmark_points_arr['solution-3'] = array(
    'time' => $elapsed,
    'result' => $result_str,
    'check_arr' => $check_arr,
    'result_arr' => $result_arr,
);
// end SOLUTION 3

//
// Start SOLUTION 4: array_search($search, $arr, true)
//
$result_str = ''; // var to display what the result of a check was
$result_arr = array(); // initialize result array
// initialize & empty result array
$startTime = microtime(true);

$check = array_search(1, $big_arr, true);

$check_arr = $big_arr;

if ($check === false) {
    $result_arr = $big_arr; // we do not have 1 in our big_arr, but display check_arr to be sure sort worked correctly
    $result_str = 'false';

} else {
    $result_arr = markAllAsX($big_arr); // we have 1 in big_arr, so change all values to X
    $result_str = 'true';
}

$endTime = microtime(true);
$elapsed = ($endTime - $startTime) * 1000;
$benchmark_points_arr['solution-4'] = array(
    'time' => $elapsed,
    'result' => 'Check: ' . $check . '<br>' . $result_str,
    'check_arr' => $check_arr,
    'result_arr' => $result_arr,
);
// end SOLUTION 4

//
// Start SOLUTION 5: array_search($search, $arr) without true (STRICT)
//
$result_str = ''; // var to display what the result of a check was
$result_arr = array(); // initialize result array
// initialize & empty result array
$startTime = microtime(true);

$check = array_search(1, $big_arr);

$check_arr = $big_arr;

if ($check === false) {
    $result_arr = $big_arr; // we do not have 1 in our big_arr, but display check_arr to be sure asort worked correctly
    $result_str = 'false';

} else {
    $result_arr = markAllAsX($big_arr); // we have 1 in big_arr, so change all values to X
    $result_str = 'true';
}

$endTime = microtime(true);
$elapsed = ($endTime - $startTime) * 1000;
$benchmark_points_arr['solution-5'] = array(
    'time' => $elapsed,
    'result' => 'Check: ' . $check . '<br>' . $result_str,
    'check_arr' => $check_arr,
    'result_arr' => $result_arr,
);
// end SOLUTION 5

//

$winning_solution = '';
$winning_time = 0;
foreach ($benchmark_points_arr as $point_name => $res_arr) {
    // first fill with data at i=1
    if ($winning_time == 0) {
        $winning_solution = $point_name;
        $winning_time = $res_arr['time'];
    } // end if

    // change on better result
    if ($res_arr['time'] < $winning_time) {
        $winning_solution = $point_name;
        $winning_time = $res_arr['time'];

    } // end if

} // end foreach

$endScriptTime = microtime(true);
$elapsedScriptTotalTime = ($endTime - $startScriptTime) * 1000;

print '<h1>Winning Solution: "' . $winning_solution . '" finished in ' . number_format($winning_time, 5) . ' ms</h1>';

print '<pre>
Solutions used and benchmarked<ol>
<li>Straight check if(in_array==true)</li>
<li>First run array_unique to minimize array values to be checked for test (result array will contain a max. of 10 elements as only those integers are possible)<br>
Run if(in_array==true)</li>
<li>First run a sort of big_arr (from lowest to highest)
<br>Now check (compare) element with key=0.
<br>If value 1 is in our big_arr, it will be found on <br>
if( sort($big_arr[0]) == 1)</li>
<li>array_search($search, $arr, true) with STRICT</li>
<li>array_search($search, $arr) without STRICT</li>
</ol>
</pre>';

print '<p>Total time for checking ' . number_format($big_arr_num_elements, 0, ',', '.') . ' elements in array ' . number_format($elapsedScriptTotalTime, 5, ',', '.') . ' ms </p>';

$benchmark_results_rows = '';
$i = 0;
foreach ($benchmark_points_arr as $point_name => $res_arr) {
    $i++;
    $time_formatted = number_format($res_arr['time'], 5);
    $bg_color = $i % 2 === 0 ? '#eeeeee' : '#ffffff'; // alternate row bg color
    $benchmark_results_rows .= '<tr valign="top" style="background-color:' . $bg_color . ';">
    <td style="width:200px; padding:5px;"><b>' . ucfirst(str_replace('-', ' ', $point_name)) . '</b></td>
    <td align="right" style="padding:5px;">' . $time_formatted . ' ms</td>
    <td align="right" style="padding:5px;">' . $res_arr['result'] . '</td>';

    if ($big_arr_num_elements > $big_arr_limit_display_num_elements) {
        // do not display big arr
        $benchmark_results_rows .= '<td style="padding:5px;"><pre>to many elements (' . $big_arr_num_elements . ') to be displayed here</pre></td>';
        $benchmark_results_rows .= '<td style="padding:5px;"><pre>to many elements (' . $big_arr_num_elements . ') to be displayed here</pre></td>';
    } else {
        $benchmark_results_rows .= '<td style="padding:5px;"><pre>' . print_r($res_arr['check_arr'], true) . '</pre></td>';
        $benchmark_results_rows .= '<td style="padding:5px;"><pre>' . print_r($res_arr['result_arr'], true) . '</pre></td>';
    }

    $benchmark_results_rows .= '</tr>';

}

print '<hr>
<h1>Results:</h1>
<table>
<tr style="background-color:#ffcc00; font-weight:bold;">
<td>Solution ID</td>
<td>Time to execute</td>
<td>Is 1 in array</td>
<td>Checked arr</td>
<td>RESULT</td>
</tr>
' . $benchmark_results_rows . '</table>';

function markAllAsX($arr)
{

    // how many elements does this array have
    $arrNumElements = count($arr);
    // just create a new array with all X-es and return it
    return array_fill(0, $arrNumElements, 'X');

}
