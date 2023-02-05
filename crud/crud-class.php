<?php

class crud
{
    public function fetch()
    {
        $data = file_get_contents(__DIR__ . "/../data.json");
        $jdata = json_decode($data, true);
        $html = "
                <table class='table-users'>
                    <tr>
                        <th>Логин</th>
                        <th>Пароль</th>
                        <th>Email</th>
                        <th>Имя</th>
                        <th>Действия</th>
                    </tr>
            ";
        if (count($jdata) != 0) {
            foreach ($jdata as $item) {
                $html .= "
                    <tr>
                        <td><p id='login" . $item['id'] . "' contenteditable='true'>" . $item['login'] . "</p></td>
                        <td><p id='password" . $item['id'] . "' contenteditable='true'>" . $item['password'] . "</p></td>
                        <td><p id='email" . $item['id'] . "' contenteditable='true'>" . $item['email'] . "</p></td>
                        <td><p id='username" . $item['id'] . "' contenteditable='true'>" . $item['username'] . "</p></td>
                        <td>
                            <i onclick='edit(" . $item['id'] . ");' class='fa-solid fa-check green'></i>
                            <i onclick='del(" . $item['id'] . ");' class='fa-solid fa-xmark red'></i>
                        </td>
                    </tr>
                    ";
            }
        }
        $html .= "
                    <tr>
                        <td><p id='login' contenteditable='true'></p></td>
                        <td><p id='password' contenteditable='true'></p></td>
                        <td><p id='email' contenteditable='true'></p></td>
                        <td><p id='username' contenteditable='true'></p></td>
                        <td>
                            <i onclick='addnew();' class='fa-solid fa-check green'></i>
                            <i onclick='cancelnew();' class='fa-solid fa-xmark red'></i>
                        </td>
                    </tr>
                </table>";
        echo $html;
    }

    public function addnew($login, $password, $email, $username)
    {
        $data = file_get_contents(__DIR__ . "/../data.json");
        $jdata = json_decode($data, true);
        $i = count($jdata);
        $i++;
        $newdata = array(
            'id' => $i,
            'login' => $login,
            'password' => md5($password . 'тест'),
            'email' => $email,
            'username' => $username);
        $jdata[] = $newdata;
        $finaldata = json_encode($jdata);
        if (file_put_contents(__DIR__ . "/../data.json", $finaldata)) {
            echo "Успешно добавлено!";
        } else {
            echo "Ошибка!";
        }
    }

    public function del($id)
    {
        $data = file_get_contents(__DIR__ . "/../data.json");
        $jdata = json_decode($data, true);
        $id--;
        unset($jdata[$id]);
        $jdata = array_values($jdata);
        $finaldata = json_encode($jdata);
        if (file_put_contents(__DIR__ . "/../data.json", $finaldata)) {
            echo "Запись удалена!";
        } else {
            echo "Ошибка!";
        }
    }

    public function edit($id, $login, $password, $email, $username)
    {
        $data = file_get_contents(__DIR__ . "/../data.json");
        $jdata = json_decode($data, true);
        $id--;
        $jdata[$id]['login'] = $login;
        $jdata[$id]['password'] = $password;
        $jdata[$id]['email'] = $email;
        $jdata[$id]['username'] = $username;
        $jdata = array_values($jdata);
        $finaldata = json_encode($jdata);
        if (file_put_contents(__DIR__ . "/../data.json", $finaldata)) {
            echo "Запись изменена!";
        } else {
            echo "Ошибка!";
        }
    }
}

?>