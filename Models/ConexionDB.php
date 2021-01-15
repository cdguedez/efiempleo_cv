<?php namespace Core;

class ConexionDB {

    public $host = [
        'hostname'  => 'localhost',
        'userdb'    => 'efiemple_test_wp',
        'database'  => 'efiemple_test_wp',
        'userpass'  => 'Zvr%P*JYz(a@'
    ];
    public $con;

    public function __construct() {
        $this->con = \mysqli_connect($this->host['hostname'],
                                    $this->host['userdb'],
                                    $this->host['userpass'],
                                    $this->host['database']
                                );
    }

    public function disconected() {
        \mysqli_close($this->con);
    }

    public function consultaRetorno($query) {
        $result = \mysqli_query($this->con, $query);
        return $result;
    }
    public function consultaSimple($query) {
        $result = \mysqli_query($this->con, $query);
    }
}