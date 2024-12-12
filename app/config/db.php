<?php
if (!class_exists('Database')) {

class Database {
    private static $connexion;

    // Méthode pour obtenir la connexion PDO
    public static function getConnexion() {
        if (self::$connexion === null) {
            try {
                // Paramètres de la connexion à la base de données
                $host = 'localhost';
                $dbname = 'smartfarm';  // Remplacez par votre base de données
                $username = 'root';     // Remplacez par votre utilisateur
                $password = '';         // Remplacez par votre mot de passe
                
                // Création de la connexion PDO
                self::$connexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
            
        }
        

        return self::$connexion;
    }

    public static function prepare($sql) {
        // Use the getConnexion() method to get the PDO connection and prepare the query
        return self::getConnexion()->prepare($sql);
    }

    // Method to execute a simple SQL query
    public static function query($sql) {
        // Use the getConnexion() method to get the PDO connection and execute the query
        return self::getConnexion()->query($sql);
    }
}
}
?>
