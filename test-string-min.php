<?php

mb_internal_encoding('UTF-8');

print '<h3>Task 2 Final Result</h3>
<pre>Napiši funkcijo, ki sprejme string in ga skrajša, v primeru da si v njem sledi več istih zaporednih znakov.
Primer: čokooolada naj spremeni v čoko3lada.</pre>';

$string = 'čokooolada'; // string to be analyzed and modified

//
// Do not modify bellow this line
//

print '<p>Input: ' . $string . '</p>
<p>Output: ' . str_reduce_duplicates($string) . '</p>';

// OUR RESULTING FUNCTION
function str_reduce_duplicates($string)
{
    $r_final = '';
    $c = 1; // duplicate counter
    $i = 0; // character position in our string
    $lastLetter = ''; // for start

    $tmpStr = $string; // create a copy of array for while parse

    // break string into array of characters
    $strLettersArr = array();
    do {
        $strLetter = mb_substr($tmpStr, 0, 1, 'utf-8');
        if ($strLetter != '') {
            $strLettersArr[] = $strLetter;
        }
    } while ($tmpStr = mb_substr($tmpStr, 1, mb_strlen($tmpStr), 'utf-8'));

    foreach ($strLettersArr as $pos => $currLetter) {

        $nextPos = $pos + 1;

        if ($currLetter == $lastLetter) {
            // we have duplicate in a row
            $c++;
        } else {
            // register duplicates of previous character
            if ($c > 1) {
                $r_final .= $lastLetter . $c;
                $c = 1; // reset counter
            }

            $nextLetter = $strLettersArr[$nextPos]; // need to check next letter here
            if ($currLetter == $nextLetter) {
                // do not display since we have a repeater in next char
            } else {
                // add current character as next one will be different
                $r_final .= $currLetter;
            } // end if
        } // end if

        $lastLetter = $currLetter;
    } // end foreach

    // repeater on last char - it was not displayed above
    if ($c > 1) {
        $r_final .= $c;
    }

    return $r_final;
}
