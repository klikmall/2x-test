<?php
mb_internal_encoding('UTF-8');

print '<h3>Task 2</h3>
<pre>Napiši funkcijo, ki sprejme string in ga skrajša, v primeru da si v njem sledi več istih zaporednih znakov.
Primer: čokooolada naj spremeni v čoko3lada.</pre>';

// $str = 'cokooolada';  // but will not work correctly in some cases with special chars like š, č, ć, ž, đ, š


$strings_arr = array(
    // https://stackoverflow.com/questions/38143475/string-compression-in-php
    # 'aaaabbaaaababbbcccccccccccc',  // -> 424ba312, a4b2a4b1a1b3c12

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

print '<h1 style="color:green;">str_reduce_duplicates</h1>';
foreach ($strings_arr as $string) {
    print '<p>Check "' . $string . '"<br>Result:<pre>' . str_reduce_duplicates($string) . '</pre></p>';
}

// NOT working properly
print '<hr>';
print '<p style="color:red;">Found these functions on web, but not working properly for our case if string includes č, š, ...</p>';

print '<h1 style="color:red;">str_preg_match</h1>';
print '<a href="https://stackoverflow.com/questions/38143475/string-compression-in-php" target="_New">https://stackoverflow.com/questions/38143475/string-compression-in-php</a><br>';
foreach ($strings_arr as $string) {
    print '<p>Check "' . $string . '"<br>Result:<pre>' . str_preg_match($string) . '</pre></p>';
}

print '<hr>';

print '<h1 style="color:red;">lineEncoding</h1>';
print '<a href="https://stackoverflow.com/a/37365713" target="_New">https://stackoverflow.com/a/37365713</a><br>';

foreach ($strings_arr as $string) {
    print '<p>Check "' . $string . '"<br>Result:<pre>' . lineEncoding($string) . '</pre></p>';
}

print '<hr>';



// OUR RESULTING FUNCTION
function str_reduce_duplicates($string)
{

    $r_process = ''; // result
    $r_final = '';
    $c = 1; // duplicate counter
    $i = 0; // character position in our string
    $lastLetter = ''; // for start

    $tmpStr = $string; // create a copy of array for while parse

    // break string into array of characters
    $strLettersArr = array();
    do {
        $strLetter = mb_substr($tmpStr, 0, 1, 'utf-8');
        # print '('.$strLetter.')<br>';
        if ($strLetter != '') {
            $strLettersArr[] = $strLetter;
        }
    } while ($tmpStr = mb_substr($tmpStr, 1, mb_strlen($tmpStr), 'utf-8'));

    // Resulting array of characters
    # print '$strLettersArr<pre>'.print_r($strLettersArr ,true).'</pre>';

    foreach ($strLettersArr as $pos => $currLetter) {

        $nextPos = $pos + 1;
        # print $pos.' ~ lastLetter : '.$lastLetter .' ::: currLetter : '.$currLetter .' ::: nextLetter: '.$nextLetter . '<br>';

        if ($currLetter == $lastLetter) {
            // we have duplicate in a row
            $c++;
        } else {
            // register duplicates of previous character
            if ($c > 1) {
                $r_process .= '(' . $c . 'x)' . $lastLetter;
                $r_final .= $lastLetter.$c;
                $c = 1; // reset counter
            }

            $nextLetter = $strLettersArr[$nextPos]; // need to check next letter here
            if ($currLetter == $nextLetter) {
                // do not display since we have a repeater in next char
            } else {
                // add current character as next one will be different
                $r_process .= $currLetter;
                $r_final .= $currLetter;
            } // end if
        } // end if

        $lastLetter = $currLetter;
    } // end foreach

    // repeater on last char - it was not displayed above
    if ($c > 1) {
        $r_process .= '(' . $c . 'x)' . $lastLetter;
        $r_final .= $lastLetter . $c;
    }

    // Internal print of result
    /*
    print '<p style="color:#999999;">
    $r_process: ' . $r_process . '<br>
    $r_final: ' . $r_final . '<br>
    </p>';
    */
    return $r_final;
}

//
// Found on web, but not working properly for our case if includes č, š, ...
//
/*
1) https://stackoverflow.com/a/38143750
Error: č ... not being breaked and processed properly
 */
function str_preg_match($str)
{
    preg_match_all('/(.)\1*/', $str, $m, PREG_SET_ORDER);
    $m = array_map(function ($i) {
        // return $i[1] . strlen($i[0]);  // original

        //  for our case
        if (strlen($i[0]) > 1) {
            // return $i[1]; // if wanted only 1 print of duplicated character
            // return strlen($i[0]); // if wanted only Number of repetitions
            return $i[1] . strlen($i[0]);
        } else {
            return $i[1];
        }
    }, $m);
    return implode('', $m); // a4b2a4b1a1b3c12
}

/*
2) https://stackoverflow.com/a/37365713
Error: č ... not being breaked and processed properly
 */
function lineEncoding($s)
{
    $l = strlen($s); // calculate strlen instead of
    // using function into the for-loop
    // for performance purpose
    $r = ''; // result
    $c = 1; // duplicate counter
    $o = $s[0]; // first character
    for ($i = 1; $i < $l; ++$i) { // starting analyze from second character
        if ($s[$i] == $o) {
            // we have duplicate in a row
            ++$c;
        } else {
            // duplicates ends, form result string
            // if counter == 1, just put the character w/o counter
            $r .= ($c>1) ? $o.$c : $o; // original by author

            // save character last found for further analyze
            $c = 1;
            $o = $s[$i];
        }
    }
    // put the last character(s) into the result
    $r .= ($c > 1) ? $o . $c : $o;
    return $r;
}
