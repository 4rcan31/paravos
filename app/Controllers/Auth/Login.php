<?php

Form();
core('Encrypt/hasher.php', false);

class Login extends BaseController {

    private array $roles = ["admin", "user"];

    private function user(): UsersModel {
        return model('UsersModel');
    }

    private function staff(): StaffModel {
        return model("StaffModel");
    }

    /* 
        La funcion login funciona de esta manera:

        primero, verifica la sintaxis del correo que envio el usuario, si la sintaxis
        es la siguiente:

        {{email}}:admin

        esto significa que ese usuario trata de iniciar session como administrador
        por lo tanto, se buscara en la tabla de "staff"

        si no tiene esta sintaxis, se buscara en la tabla de "users"
    */
    public function login($request) {
        $this->validateCsrfTokenWithRedirection($request, "/login");

        $validate = validate($request);
        $validate->rule('required', ['email', 'password']);
        $validate->rule('email', ['email']);

        $this->redirectWithBoolCondition(
            !$validate->validate(),
            "/login",
            $validate->err()
        );

        $email = $validate->input("email");
        $password = $validate->input("password");

        if (strpos($email, ':admin') !== false) {
            list($email, $role) = explode(':', $email);
            $this->loginAsAdmin($email, $password);
        } else {
            $this->loginAsUser($email, $password);
        }
    }

    public function logout($request) {
        $validate = validate($request);
        $validate->rule("required", [0]);

        $rol = $request[0];

        if (!in_array($rol, $this->roles) || !$validate->validate()) {
            Sauth::logoutClient();
            Form::send("/", ["Tu sesión expiró"], "Error");
        }

        if ($rol == "user") {
            $this->logoutClient();
        } else if ($rol == "admin") {
            $this->logoutAsAdmin();
        }
    }

    private function loginAsAdmin($email, $password) {
        if (!$this->staff()->existByEmail($email)) {
            Form::send("/login", ["Credenciales incorrectas: no existe usuario"], "Error");
        }

        $row = $this->staff()->getByEmail($email);
        if (!Hasher::verify($password, $row->password)) {
            Form::send('/login', ['Credenciales incorrectas: contraseña incorrecta'], 'Error');
        }

        Sauth::NewAuthServerSave('staff', 'remember_token', $row->id);
        Sauth::NewAuthClient([
            'id' => $row->id,
            'name' => $row->name,
            "rol" => "admin"
        ], $_ENV['APP_KEY']);

        Form::send("/admin/home", ['Ha iniciado sesión correctamente!'], "Notice");
    }

    private function loginAsUser($email, $password) {
        if (!$this->user()->existByEmail($email)) {
            Form::send("/login", ["Credenciales incorrectas: no existe usuario"], "Error");
        }

        $row = $this->user()->getByEmail($email);
        if (!Hasher::verify($password, $row->password)) {
            Form::send('/login', ['Credenciales incorrectas: contraseña incorrecta'], 'Error');
        }

        Sauth::NewAuthServerSave('users', 'remember_token', $row->id);
        Sauth::NewAuthClient([
            'id' => $row->id,
            'name' => $row->name,
            "rol" => "user"
        ], $_ENV['APP_KEY']);

        Form::send("/", ['Ha iniciado sesión correctamente!'], "Notice");
    }

    private function logoutAsAdmin() {
        $idAdmin = $this->clientAuth()->id;
        $rolAdmin = $this->clientAuth()->rol;

        if ($rolAdmin == "admin") {
            Sauth::logoutClient();
            Sauth::logoutServer('staff', 'remember_token', $idAdmin);
            Form::send('/', ['Se cerró sesión correctamente'], 'Notice');
        } else {
            Sauth::logoutClient();
            Form::send('/', ['Su sesión expiró'], 'Notice');
        }
    }

    private function logoutClient() {
        $idUser = $this->clientAuth()->id;
        $rolUser = $this->clientAuth()->rol;

        if ($rolUser == "user") {
            Sauth::logoutClient();
            Sauth::logoutServer('users', 'remember_token', $idUser);
            Form::send('/', ['Se cerró sesión correctamente'], 'Notice');
        } else {
            Sauth::logoutClient();
            Form::send('/', ['Su sesión expiró'], 'Notice');
        }
    }
}
