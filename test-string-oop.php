<?php

mb_internal_encoding('UTF-8');


class ReduceDuplicatesClass
{   
    
    public function reduceDuplicatesFunction($string)
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
    } // end function
} // end class

$reduceDuplicates = new ReduceDuplicatesClass;

$string = 'čokooolada'; // string to be analyzed and modified
# Print result
echo $reduceDuplicates->reduceDuplicatesFunction($string);


# Tests
print '<hr>';

$strings_arr = array(
    'čokooolada', // task
    // additional tests
    'ččokooolada', // check process for start repeater
    'ččokoooladaaa', // check process for end repeater
    'ččokooolada doobrraaa', // check process for multiple words
    'veryy fine chhocoladeee by Lindt', // task
    'how will this turn out Ä Ö Ü ÄÄÖÜ ÄÖÖÜ ÄÖÜÜ? ? ?? ! !! . ..'
);


//
// Do not modify bellow this line
//

print '<h3>Run each function for given task trough array of strings bellow for multiple results</h3>
<pre>' . print_r($strings_arr, true) . '</pre>';

print '<h1 style="color:green;">Tests</h1>';
foreach ($strings_arr as $string) {
    print '<p>Check "' . $string . '"<br>Result:<pre>' . $reduceDuplicates->reduceDuplicatesFunction($string) . '</pre></p>';
}