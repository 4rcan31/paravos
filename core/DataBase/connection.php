<?php 
class Connection{
    protected $connection = null;

    protected ?string $host = null;
    protected ?string $user = null;
    protected ?string $dbname = null;
    protected ?string $password = null;
    protected ?string $port = null;


    public function __construct(bool $admin = false){
        try{
            if($admin){
                $this->setCredentialsAsAdmin();
            }
            $credentials = $this->buildConnectionCredentials();
            $link = new PDO(
                $credentials['uri'],
                $credentials['user'],
                $credentials['password'],
            );
            $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $link->exec('set names utf8');
            $this->connection = $link;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function buildConnectionCredentials(){
        $host = $this->buildVar($this->host, 'DB_HOST');
        $dbname = $this->buildVar($this->dbname, 'DB_DATABASE');
        $username = $this->buildVar($this->user, 'DB_USERNAME');
        $password = $this->buildVar($this->password, 'DB_PASSWORD');
        $port = $this->buildVar($this->port, 'DB_PORT', '3306');
        return [
            "uri" => "mysql:host=".$host.";port=".$port.";dbname=".$dbname,
            "user" => $username,
            "password" => $password
        ];
    }

    public function buildVar(mixed $var, string $type, string $default = null){
        return $var === null ? ($_ENV[$type] ?? $default) : $var;
    }

    public function setCredentialsAsAdmin(string $host = null, string $port = null, string $user = null, string $dbname = null, string $password = null){
        $this->host = $this->buildVar($host, 'DB_HOST');
        $this->dbname = $this->buildVar($dbname, 'DB_DATABASE');
        //esto es para que el cli ocupe modo admin
        $this->port = $this->buildVar($port, 'DB_PORT', '3306');
        $this->user = $this->buildVar($user, 'DB_ADMIN_USERNAME');
        $this->password = $this->buildVar($password, 'DB_ADMIN_PASSWORD');
    }
}