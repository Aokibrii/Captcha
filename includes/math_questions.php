<?php
$min = 1;
$max = 10;
$operators = ['+', '-', '÷'];
$operator = $operators[array_rand($operators)];

if ($operator === '+') {
    $a = rand($min, $max);
    $b = rand($min, $max);
    $answer = $a + $b;
    $question = "$a + $b = ?";
} elseif ($operator === '-') {
    $a = rand($min, $max);
    $b = rand($min, $max);
    // Ensure non-negative result
    if ($a < $b) {
        [$a, $b] = [$b, $a];
    }
    $answer = $a - $b;
    $question = "$a - $b = ?";
} else { // Division (ensure whole number)
    $b = rand($min, $max);
    $answer = rand($min, $max);
    $a = $b * $answer;
    $question = "$a ÷ $b = ?";
}

$_SESSION['math_captcha_answer'] = $answer;
?>