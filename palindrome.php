<?php
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['string'])) {
    $str = $input['string'];

    function isPalindrome($str) {
        $str = strtolower($str);
        $length = 0;

        while (isset($str[$length])) {
            $length++;
        }

        for ($i = 0; $i < $length / 2; $i++) {
            if ($str[$i] !== $str[$length - $i - 1]) {
                return false;
            }
        }
        return true;
    }

    $result = isPalindrome($str);
    echo json_encode(["isPalindrome" => $result]);
} else {
    echo json_encode(["error" => "Please provide a 'string' in the request body."]);
}
?>
