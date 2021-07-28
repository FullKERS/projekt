<?php
include("products.php");


/**
 * The Target defines the domain-specific interface used by the client code.
 */
class Target
{
    public function request(): string
    {
        return "Target: The default target's behavior.";
    }
}

/**
 * The Adaptee contains some useful behavior, but its interface is incompatible
 * with the existing client code. The Adaptee needs some adaptation before the
 * client code can use it.
 */
class Adaptee
{
    public function tworzPolaczenie()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projektWzorce";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;

    }




}

/**
 * The Adapter makes the Adaptee's interface compatible with the Target's
 * interface.
 */
class Adapter
{
    private $adaptee;
    private $sqlConn;

    public function __construct()
    {
        $this->adaptee = new Adaptee();
        $this->sqlConn = $this->adaptee->tworzPolaczenie();
    }

    public function select($sql){
        $result = $this->sqlConn->query($sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;

    }


    public function pobierzProdukty($id =''){
        if($id == ''){
            return $this->select("SELECT * FROM `produkty` ORDER BY `nazwa`");
        }
        else{
            return $this->select("SELECT * FROM `produkty` WHERE `idProduktu` LIKE '".$id."' ORDER BY `nazwa`");
        }
        
    }


    ///funkcje


    /*public function request(): string
    {
        return "Adapter: (TRANSLATED) " . strrev($this->adaptee->specificRequest());
    }*/
}

/**
 * The client code supports all classes that follow the Target interface.
 */

function clientCode(Target $target)
{
    echo $target->request();
}
/*
echo "Client: I can work just fine with the Target objects:\n";
$target = new Target();
clientCode($target);
echo "\n\n";

$adaptee = new Adaptee();
echo "Client: The Adaptee class has a weird interface. See, I don't understand it:\n";
echo "Adaptee: " . $adaptee->specificRequest();
echo "\n\n";

echo "Client: But I can work with it via the Adapter:\n";
$adapter = new Adapter($adaptee);
clientCode($adapter);
*/

?>