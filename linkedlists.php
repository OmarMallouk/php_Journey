<?php
header("Content-Type: application/json");

class Node {
    public $data;
    public $next;

    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
    }
}

class LinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    public function append($data) {
        $newNode = new Node($data);

        if ($this->head === null) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $newNode;
        }
    }

    private function hasTwoVowels($str) {
        $vowels = 0;
        $str = strtolower($str);
        $vowelChars = ['a', 'e', 'i', 'o', 'u'];

        for ($i = 0; $i < strlen($str); $i++) {
            if (in_array($str[$i], $vowelChars)) {
                $vowels++;
            }
            if ($vowels > 2) return false;
        }

        return $vowels === 2;
    }

    public function getTwoVowelNodes() {
        $current = $this->head;
        $result = [];

        while ($current !== null) {
            if ($this->hasTwoVowels($current->data)) {
                $result[] = $current->data;
            }
            $current = $current->next;
        }

        return $result;
    }
}

$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['words']) && is_array($input['words'])) {
    $list = new LinkedList();
    
    foreach ($input['words'] as $word) {
        $list->append($word);
    }

    $twoVowelWords = $list->getTwoVowelNodes();
    echo json_encode(["twoVowelWords" => $twoVowelWords]);
} else {
    echo json_encode(["error" => "Invalid"]);
}
?>
