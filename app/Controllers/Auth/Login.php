<?php
Form();
core('Encrypt/hasher.php', false);

class Login extends BaseController{

    private array $roles = [
        "admin", "user"
    ];

    private function user() : UsersModel{
        return model('UsersModel');
    }


    public function login($request){
        $this->validateCsrfTokenWithRedirection($request, "/login");
        $validate = validate($request);
        $validate->rule('required', ['email', 'password']); 
        $validate->rule('email', ['email']);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            "/login",
            $validate->err()
        );

        $explode = explode(":", $validate->input("email"));


        $email = $validate->input("email");

        count($explode = explode(":", $email)) > 1 && $explode[1] === "admin" ?
            $this->loginAsAdmin($explode[0], $validate->input("password")) :
            $this->loginAsUser($email, $validate->input("password"));
        

    }


    public function logout($request){
        $validate = validate($request);
        $validate->rule("required", [0]);
        $rol = $request[0];
        if(!in_array($rol, $this->roles) || !$validate->validate()){
            //se quiso explotar una vulnerabilidad poniendo otro rol para el cierre de session
            Sauth::logoutClient();
            Form::send("/", ["Tu session expiro"], "Error");
        }
        if($rol == "user"){
            $this->logoutClient();
        }else if($rol == "admin"){
            $this->logoutAsAdmin();
        }
        
    }
    

    public function loginAsAdmin($email, $pasword){

    }

    public function logoutAsAdmin(){
        $idAdmin = $this->clientAuth()->id;
        $rolAdmin = $this->clientAuth()->rol; // se espera que sea admin

    }

    public function loginAsUser($email, $pasword){
        $exist = $this->user()->existByEmail($email);
        if(!$exist){
           Form::send("/login", ["Credenciales incorrectas no existe user"], "Error");
        }
        $row = $this->user()->getByEmail($email);
        if(!Hasher::verify($pasword, $row->password)){ 
            Form::send('/login', ['Credenciales incorrectas password icorrecta'], 'Error'); 
        }
        Sauth::NewAuthServerSave('users', 'remember_token', $row->id);
        Sauth::NewAuthClient([
            'id' => $row->id,
            'name' => $row->name,
            "rol" => "user" //esto para identificar este token
        ],$_ENV['APP_KEY']);
        Form::send("/", ['Ha iniciado session correctamente!'], "Notice");
    }

    public function logoutClient(){
        $idUser = $this->clientAuth()->id;
        $rolUser = $this->clientAuth()->rol;
        if($rolUser == "user"){
            Sauth::logoutClient();
            Sauth::logoutServer('users', 'remember_token', $idUser);
            Form::send('/', ['Se cerro session correctamente'], 'Notice');
            return;
        }else{
            //si esto para es por que alguien quiere explotar una vulnerabilidad, quiere cerrar la session
            // del usuario con un token authenticado
            Sauth::logoutClient();
            Form::send('/', ['Su session expiro'], 'Notice');
        }

    }
}