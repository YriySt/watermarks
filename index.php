<?php

/**
 * @param $input
 * @return mixed
 * @todo implement function
 */

$cases = [];
$cases = [
            ['2021-03-23 12:00:00', '2021-03-23 15:00:00'],
            ['2021-03-23 10:00:00', '2021-03-23 14:00:00'],
            ['2021-03-24 12:00:00', '2021-03-24 15:00:00'],
            ['2021-03-23 9:00:00', '2021-03-23 16:00:00'],
            ['2021-03-24 13:00:00', '2021-03-24 16:00:00'],
            ['2021-03-25 12:00:00', '2021-03-25 15:00:00'],
            ['2021-03-26 12:00:00', '2021-03-26 15:00:00'],
         ];

function merge(array $input)
{
    $output = [];
    $elCount = count($input);
    for($i = 0; $i < $elCount; $i++) {
        $dateMin = date('Y-m-d H:i:s', strtotime($input[$i][0]));
        $dateMax = date('Y-m-d H:i:s', strtotime($input[$i][1]));
        for($b = 1; $b < $elCount; $b++){
            $minNext = date('Y-m-d H:i:s', strtotime($input[$b][0]));
            $maxNext = date('Y-m-d H:i:s', strtotime($input[$b][1]));
            if ($dateMin > $minNext && $dateMin < $maxNext) {
                $output[$i][0] = min([$minNext, $dateMin]);
                $output[$i][1] = max([$maxNext, $dateMax]);
            } elseif($dateMin < $maxNext && $dateMax > $minNext && $dateMax < $maxNext){
                $output[$i][0] = min([$minNext, $dateMin]);
                $output[$i][1] = max([$maxNext, $dateMax]);
            }
        }
    }
    foreach ($output as $key => $value){
        foreach ($input as $keyInput => $inValue){
            if($value[0] <= $inValue[0] && $value[1] >= $inValue[1]){
                $input[$keyInput][0] = $value[0];
                $input[$keyInput][1] = $value[1];
            }
        }
    }


    $resData = array_unique($input, SORT_REGULAR);

    return $resData;
}

$res = merge($cases);
echo '<pre>';
print_r($res);
echo "</pre>";
