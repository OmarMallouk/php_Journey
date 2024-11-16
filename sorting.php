<?php

for ($i = 0; $i < 20; $i++) {
    $numbers[] = rand(1, 20);
}

$result = $numbers;

mergeSort($numbers, $result);

// header("Content-Type: application/json");


function mergeSort(array $numbers, array &$result) {
    echo "Original array: ";
    echo implode(',', $numbers) . "\n";

    split($numbers, 0, count($numbers), $result);

    echo "Sorted array: ";
    echo implode(',', $result) . "\n";
}

function split(array &$numbers, int $indexB, int $indexE, array &$result) {
    if ($indexE - $indexB <= 1) return;

    $indexMid = intval(($indexB + $indexE) / 2);

    split($result, $indexB, $indexMid, $numbers);
    split($result, $indexMid, $indexE, $numbers);

    merge($numbers, $indexB, $indexMid, $indexE, $result);
}

function merge(array &$numbers, int $indexB, int $indexMid, int $indexE, array &$result) {
    $i = $indexB;
    $j = $indexMid;

    for ($k = $indexB; $k < $indexE; $k++) {
        if ($i < $indexMid && ($j >= $indexE || $numbers[$i] <= $numbers[$j])) {
            $result[$k] = $numbers[$i];
            $i++;
        } else {
            $result[$k] = $numbers[$j];
            $j++;
        }
    }
}

?>
