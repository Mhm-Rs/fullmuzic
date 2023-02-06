<?php

class Database
{
   //* Connexion à la base de données:

   //*variable du host
   private static $dbHost = "localhost";
   
   //*variable nom de la bdd
   private static $dbName = "fullmusic";

   //*variable user de la bdd
   private static $dbUser = "root";

   //*variable mot de passe user
   private static $dbUserPassword = "";

   //* Etat de la connexion
   private static $connection = null;

   //*connexion à la bdd
   public static function connect(){
        try{
            self::$connection = new PDO("mysql:host=" . self::$dbHost .";dbname=".self::$dbName,self::$dbUser,self::$dbUserPassword);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }

        return self::$connection;
   }

   //déconnexion de la bdd
   public static function disconnect(){
        self::$connection = null;
   }
}

    //connecter la base de données à chaque fois qu'une instance est créée
    Database::connect();
?>
