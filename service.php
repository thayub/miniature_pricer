<?php

/* * ********************************************************************
 * Filename: Service.php
 * Folder: /
 * Description:  Contains the function to get rate by interpolation
 * @author Thayub
 * Change History: - 
 * Version         Author               Change Description
 * ******************************************************************** */


# FUNCTION to find the Future Contract :

# Getting the post parameters

$currentPrice = $_POST["currentPrice"];
$input_time = $_POST["time"];


# Existing data that is used for interpolation as a key-value pair

/* SAMPLE DATA : for interpolation:
1       10%
30      5%
60      4%
90      2%
210     2%
*/

$defaultValues = array(
    "1"=>"10",
    "30"=>"5",
    "60"=>"4",
    "90"=>"2",
);

# Validation for the range of days:

if ($input_time < 0 || $input_time > 90){
    echo ('Out of range');
    echo "\n";
    echo ('Please enter a value between 1 and 90');
    echo "\n";
}else{

    # Logic to get the data for the interpolation function:

    $data = array_keys($defaultValues);

    # Getting the upper and lower limits for the interpolation:
    $count = 0;
    $newValue = 0;
    $max = count($data); 

    for ($i=0;$i<$max-1;$i++){

        $lowRange = $data[$i];
        $upRange = $data[$i+1];

        # Condition 1
        if (($input_time > $lowRange) && ($input_time < $upRange)){
               $upperLimitObj->range = $upRange;
               $upperLimitObj->value = $defaultValues[$upRange];
               $lowerLimitObj->range = $lowRange;
               $lowerLimitObj->value = $defaultValues[$lowRange];

               $newValue = interpolation($upperLimitObj,$lowerLimitObj,$input_time);
            break;
        }
        # Condition 2
        # Lower Boundary check
         if ($input_time == $lowRange){
            $newValue = $defaultValues[$lowRange];
            break;
         }

        # Condition 3
        # Upper Boundary Check
         if ($input_time == $upRange){
            $newValue = $defaultValues[$upRange];
            break;
         }
    }



    /*Formula :

    F = S * e^(r*t)
    F -> To be calculated
    S -> Current price Real time value
    e -> constant
    r -> interest rate
    t -> time of year

    */
    $finalResult = $currentPrice * exp(pow($newValue/100 , $input_time/365));
    #echo "\n";
    #echo "$currentPrice * exp(pow($newValue/100 , $input_time/365))";
    #echo "\n";

    # PRINTING THE RESULT FOR THE HTML PAGE, AJAX call:

    echo "Time in days          :   $input_time";
    echo "\n";
    echo "Current Spot Price    :   $currentPrice";
    echo "\n";
    echo "Rate of interest      :   $newValue";
    echo "\n";
    echo "\n";
    echo "Future Contract       :   $finalResult";
    echo "\n";

    # END OF PRINTING DATA

}

/* * ********************************************************************************
* Function: interpolation
* Input: Upperlimitobj, lowerLimitobj, newRange
* Description:  Linear Interpolation formula
* 
*   y2 being the new value to be found for a range x2,
*   x1,y1, and x3,y3 being the lower and upper limit range=>value pairs respectively
*   
*   y2 = ((x2-x1)(y3-y1) / (x3-x1) ) + y1
* 
* Result : The rounded value of y2 : The value for the range x2.
**************************************************************************************/
 
 
function interpolation($upperLimitObj,$lowerLimitObj,$newRange){

    $lowerValue = $lowerLimitObj->value;
    $lowerRange = $lowerLimitObj->range;
    
    $upperValue = $upperLimitObj->value;
    $upperRange = $upperLimitObj->range;

    $value = ((($newRange - $lowerRange)*($upperValue - $lowerValue) / ($upperRange - $lowerRange)) + $lowerValue);
    #echo "((($newRange - $lowerRange)*($upperValue - $lowerValue) / ($upperRange - $lowerRange)) + $lowerValue)";
    #echo "\n";
    #echo $value;
    #echo "\n";
    return $value;
}        
        
        
        
        

?>
