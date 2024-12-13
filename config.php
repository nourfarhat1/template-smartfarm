<?php
// Vérifier si la classe existe déjà pour éviter de la redéclarer
if (!class_exists('DatabaseConfig')) {
    class DatabaseConfig {
        // Déclaration des propriétés statiques privées
        private static $pdo = null;
        private static $servername = "localhost";
        private static $username = "root";
        private static $password = "";
        private static $dbname = "testsolo";

        // Méthode pour obtenir la connexion à la base de données
        public static function getConnexion() {
            if (!isset(self::$pdo)) {
                try {
                    // Création de la connexion en utilisant les propriétés statiques
                    self::$pdo = new PDO(
                        "mysql:host=" . self::$servername . ";dbname=" . self::$dbname,
                        self::$username,
                        self::$password
                    );
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    die('Erreur: ' . $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }
}
?>
