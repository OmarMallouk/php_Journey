<?php

class User {
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check_password($password) {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{12,}$/';
        return preg_match($pattern, $password) ? true : false;
    }

    public static function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    public function displayInfo() {
        return json_encode(["username" => $this->username, "email" => $this->email]);
    }
}

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['username'], $data['email'], $data['password'])) {
            $user = new User($data['username'], $data['email'], $data['password']);
            echo $user->displayInfo();
            break;
        }

        if (isset($data['password']) && !isset($data['username']) && !isset($data['email'])) {
            $isValidPassword = User::check_password($data['password']);
            echo json_encode(["password_valid" => $isValidPassword]);
            break;
        }

        if (isset($data['email']) && !isset($data['username']) && !isset($data['password'])) {
            $isValidEmail = User::validate_email($data['email']);
            echo json_encode(["email_valid" => $isValidEmail]);
            break;
        }

        echo json_encode(["error" => "Invalid input data"]);
        break;

    default:
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
