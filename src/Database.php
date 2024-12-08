<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Connection db
*/

class Database
{

    // Attribut de classe
    private $connector;

    /*
    Permet de connection base de données
    */
    public function __construct()
    {
        // Se connecter via PDO et utilise la variable de classe $connector
        try {
            $this->connector = new PDO('mysql:host=localhost:6033;dbname=db_teachers;charset=utf8', 'root', 'root');
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /*
    La requête d'adresse SQL fournie en paramètre est traitée grâce à la commande query simple execute.
    */
    private function querySimpleExecute($query)
    {
        // Permet de préparer et d'exécuter une requéte de type simple (sans where)
        return $this->connector->query($query);
    }

    /*
    La requête d'adresse SQL fournie en paramètre est traitée grâce à la commande query prepare execute.
    */
    private function queryPrepareExecute($query, $binds)
    {
        // Permet de préparer et d'exécuter une requéte de type prepare avec WHERE       
        $req = $this->connector->prepare($query);

        foreach ($binds as $bind) {
            $req->bindValue($bind[0], $bind[1], $bind[2]);
        }

        // Permet de exécuter method prepare
        $req->execute();

        return $req;
    }

    /*
    Permet de récupérer les données
    */
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    Permet de vider le jeu d'enregistrements
    */
    public function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        return $req->closeCursor();
    }

    /*
    Récupérer la liste de tous les enseignants de la BD
    */
    public function getAllTeachers()
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_teacher;";

        // Permet de préparer et d'exécuter une requéte de type simple (sans where)
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);

        // Retour les enseignants
        return $teachers;
    }

    /*
    Récupérer un enseignant de la BD
    */
    public function getOneTeacher($idTeacher)
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_teacher WHERE idTeacher = :idTeacher";

        $binds = [
            ["idTeacher", $idTeacher, PDO::PARAM_STR]
        ];

        // Permet de préparer et d'exécuter une requéte de type prepare avec WHERE 
        $req = $this->queryPrepareExecute($query, $binds);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);

        // Retour un enseignant
        return $teachers[0];
    }

    /*
    Supprimer un enseignant de la BD
    */
    public function deleteTeacher($idTeacher)
    {
        // Permet de préparer et d'exécuter une requéte de type prepare avec WHERE 
        $query = "DELETE FROM t_teacher WHERE idTeacher = :idTeacher";

        // Permet de stocker les parametres de fonction prepare
        $binds = [
            ["idTeacher", $idTeacher, PDO::PARAM_STR]
        ];

        // Permet de préparer et d'exécuter une requéte de type prepare avec WHERE
        $req = $this->queryPrepareExecute($query, $binds);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);

        // Retour un enseignant 
        return $teachers[0];
    }

    /*
    Récupérer une section de la BD
    */
    public function getOneSection($idSection)
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_section WHERE idSection = " . $idSection;

        // Permet de préparer et d'exécuter une requéte de type prepare avec WHERE
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $sections = $this->formatData($req);

        // Retour une section
        return $sections[0];
    }

    /*
    Récupérer touts les sections de la BD
    */
    public function getAllSection()
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_section";

        // Permet de préparer et d'exécuter une requéte de type simple (sans where)
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $sections = $this->formatData($req);

        // Retour touts les sections
        return $sections;
    }

    /*
    Ajouter un enseignant dans la BD
    */
    public function addTeacher($datas)
    {
        // Récupérer les données
        $firstName = $datas['firstName'];
        $lastName = $datas['name'];
        $gender = $datas['genre'];
        $nickname = $datas['nickName'];
        $origin = $datas['origin'];
        $section = $datas['section'];

        // Avoir la requête sql
        $query = "INSERT INTO `t_teacher`(`idTeacher`, `teaFirstname`, `teaName`, `teaGender`, `teaNickname`, `teaOrigine`, `fkSection`)
                                VALUES (DEFAULT, :teaFirstname, :teaName, :teaGender, :teaNickname, :teaOrigine, :fkSection)";

        // Avoir la list PDO pour requête prépare sql
        $binds = [];
        $binds[] = [":teaFirstname", $firstName, PDO::PARAM_STR];
        $binds[] = [":teaName", $lastName, PDO::PARAM_STR];
        $binds[] = [":teaGender", $gender, PDO::PARAM_STR];
        $binds[] = [":teaNickname", $nickname, PDO::PARAM_STR];
        $binds[] = [":teaOrigine", $origin, PDO::PARAM_STR];
        $binds[] = [":fkSection", $section, PDO::PARAM_STR];

        // Ajout de données avec requête préparée (requête paramétrée)
        $req = $this->queryPrepareExecute($query, $binds);

        return $req;
    }

    /*
    Mettre à jour un enseignant dans la BD
    */
    public function updateTeacher($datas)
    {
        // Récupérer les données
        $idTeacher = $datas['idTeacher'];
        $firstName = $datas['firstName'];
        $lastName = $datas['name'];
        $gender = $datas['genre'];
        $nickname = $datas['nickName'];
        $origin = $datas['origin'];
        $section = $datas['section'][0];

        // Ajout de données avec requête préparée (requête paramétrée)
        $query = "UPDATE `t_teacher` SET `teaFirstname` = :teaFirstname, `teaName` = :teaName, `teaGender` = :teaGender, ";
        $query .= " `teaNickname` = :teaNickname, `teaOrigine` = :teaOrigine, `fkSection` = :fkSection WHERE `idTeacher` = $idTeacher";


        // Avoir la list PDO pour requête prépare sql
        $binds = [];
        $binds[] = [":teaFirstname", $firstName, PDO::PARAM_STR];
        $binds[] = [":teaName", $lastName, PDO::PARAM_STR];
        $binds[] = [":teaGender", $gender, PDO::PARAM_STR];
        $binds[] = [":teaNickname", $nickname, PDO::PARAM_STR];
        $binds[] = [":teaOrigine", $origin, PDO::PARAM_STR];
        $binds[] = [":fkSection", $section, PDO::PARAM_STR];

        // Ajout de données avec requête préparée (requête paramétrée)
        $req = $this->queryPrepareExecute($query, $binds);

        return $req;
    }
}
