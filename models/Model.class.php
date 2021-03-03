<?php 

abstract class Model                
{
    private static $pdo;                 
    

    // CREATION DE CONNEXION
    private static function setBdd()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=biblio2;charset=utf8", "root", "");
        self::$pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING);
    }

    // SI CONNEXION, RETOURNE LA VALEUR DE L'ATTRIBUT STATIQUE
    protected function getBdd()
    {
        if (self::$pdo === null) {
            self::setBdd();
        }

        return self::$pdo;
    }

}






// private => info accessible que depuis la classe Model
// protected => info accessible par les classes filles

// abstract => Cette classe n'aura pas à être instanciée

// static => Accessible ds ttes les classes filles qui héritent de la classe Model