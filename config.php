<?php
class config  
{   private static $pdo = null;//variable pde pour connecter 
    public static function getConnexion()//fct bch naaytoulha mbaad fl les fichiers lkol bch naamlou connection mteena 
    {
        if (!isset(self::$pdo)) {
            $servername="localhost";
            $username="root";    
            $password ="";
            $dbname="event";

            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname",//function predéfinie pur faire la connection 
                        $username,
                        $password
                );

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                //ithaken saret el execution bil shih
                //echo "connection reussite";
            } catch (Exception $e) {
                //ithaken saret el execution bil 88alit
                die('Erreur: ' . $e->getMessage());
            }
        }
        //iraji3 el connection
        return self::$pdo;
    }
}
//exemple d'un appel
config::getConnexion();
?>









