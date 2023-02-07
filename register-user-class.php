<?php

class RegisterUser
{
    private $login;
    private $raw_password;
    private $confirm_password;
    private $email;
    private $username;
    private $encrypted_password;

    public $error;
    public $loginError;
    public $passwordError;
    public $confirmPasswordError;
    public $emailError;
    public $success;
    private $storage = "data.json";
    private $stored_users;
    private $new_user;

    public function __construct(
        $login,
        $password,
        $confirm_password,
        $email,
        $username
    )
    {

        $this->login = trim($login);

        $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
        $this->encrypted_password = md5($this->raw_password . 'тест');


        $this->confirm_password = filter_var(trim($confirm_password), FILTER_SANITIZE_STRING);

        $this->email = trim($email);

        $this->username = trim($this->username);
        $this->username = filter_var($username, FILTER_SANITIZE_STRING);

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "id" => count($this->stored_users) + 1,
            "username" => $this->username,
            "password" => $this->encrypted_password,
            "login" => $this->login,
            "email" => $this->email
        ];

        if ($this->checkFieldValues()) {
            $this->insertUser();
        }
    }


    private function checkFieldValues()
    {
        $letter = preg_match('@[A-Za-z]@', $this->raw_password);
        $letterUsername = preg_match('@[A-Za-z]@', $this->username);
        $number = preg_match('@[0-9]@', $this->raw_password);
        $space = preg_match("|\s|", $this->username);

        if (
            empty($this->login) ||
            empty($this->raw_password) ||
            empty($this->email) ||
            empty($this->username)
        ) {
            $this->error = "Все поля должны быть заполнены.";
            return false;
        } else if ($this->raw_password !== $this->confirm_password) {
            $this->confirmPasswordError = "Пароли не совпадают";
            return false;
        } else if (strlen($this->login) < 6) {
            $this->loginError = "Длина логина - не менее 6 символов";
            return false;
        } else if (!$letter || !$number) {
            $this->passwordError = "Пароль должен содержать цифры и буквы";
            return false;
        } else if (strlen($this->raw_password) < 6) {
            $this->passwordError = "Длина пароля - минимум 6 символов";
            return false;
        } else if (!(filter_var($this->email, FILTER_VALIDATE_EMAIL))) {
            $this->emailError = "Email указан неверно";
            return false;
        } else if (!$letterUsername) {
            $this->error = "Имя пользователя должно содержать только буквы";
            return false;
        } else if (strlen($this->username) < 2) {
            $this->error = "Длина имени - минимум 2 символа";
            return false;
        } else if ($space) {
            $this->error = "Имя не должно содержать пробелы";
            return false;
        } else {
            return true;
        }
    }

    private function isLoginUnique()
    {
        foreach ($this->stored_users as $user) {
            if ($this->login == $user['login']) {
                $this->loginError = "Логин уже используется.";
                return true;
            }
        }
        return false;
    }

    private function isEmailUnique()
    {
        foreach ($this->stored_users as $user) {
            if ($this->email == $user['email']) {
                $this->emailError = "Email уже используется.";
                return true;
            }
        }
        return false;
    }
    
    private function insertUser()
    {
        if (!$this->isLoginUnique()) {
            if (!$this->isEmailUnique()) {
                $this->stored_users[] = $this->new_user;
                if (file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))) {
                    return $this->success = "Регистрация прошла успешно";
                } else {
                    return $this->emailError = "Логин и Email должны быть уникальными";
                }
            }
        }
    }
}