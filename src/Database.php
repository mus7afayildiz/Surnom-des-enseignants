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

    /**
     * TODO: � compl�ter
     */
    public function __construct()
    {
        // TODO: Se connecter via PDO et utilise la variable de classe $connector
        try {
            $this->connector = new PDO('mysql:host=localhost:6033;dbname=db_teachers;charset=utf8', 'root', 'root');
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /**
     * TODO: � compl�ter
     */
    private function querySimpleExecute($query)
    {
        // TODO: permet de pr�parer et d�ex�cuter une requ�te de type simple (sans where)
        return $this->connector->query($query);
    }

    /**
     * TODO: � compl�ter
     */
    private function queryPrepareExecute($query, $binds)
    {
        //permet de préparer et d'exécuter une requéte de type prepare avec WHERE       
        $req = $this->connector->prepare($query);

        foreach($binds as $bind) {
            $req->bindValue($bind[0], $bind[1], $bind[2]);
        }
        
        $req->execute();

        return $req;
    }

    /**
     * TODO: � compl�ter
     */
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * TODO: � compl�ter
     */
    private function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        return $req->closeCursor();
    }

    /**
     * Récupérer la liste de tous les enseignants de la BD
     */
    public function getAllTeachers()
    {
        // avoir la requête sql
        $query = "SELECT * FROM t_teacher;";

        // appeler la méthode pour executer la requ�te
        $req = $this->querySimpleExecute($query);

        // TODO: appeler la m�thode pour avoir le r�sultat sous forme de tableau
        $teachers = $this->formatData($req);

        //var_dump($teachers);
        // TODO: retour tous les enseignants

        return $teachers;
    }

    /**
     * TODO: � compl�ter
     */
    public function getOneTeacher($idTeacher)
    {
        $query = "SELECT * FROM t_teacher WHERE idTeacher = :idTeacher";

        $binds = [
            ["idTeacher", $idTeacher, PDO::PARAM_STR]
        ];

        $req = $this->queryPrepareExecute($query, $binds);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);

        return $teachers[0];
    }

    public function deleteTeacher($idTeacher)
    {
        $query = "DELETE FROM t_teacher WHERE idTeacher = :idTeacher";
        $binds = [
            ["idTeacher", $idTeacher, PDO::PARAM_STR]
        ];

        $req = $this->queryPrepareExecute($query, $binds);
        //$req = $this->querySimpleExecute($query);
        
        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);

        return $teachers[0];
    }

    public function getOneSection($idSection)
    {
        $query = "SELECT * FROM t_section WHERE idSection = " . $idSection;
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $sections = $this->formatData($req);

        return $sections[0];
    }

    public function getAllSection()
    {
        $query = "SELECT * FROM t_section";
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $sections = $this->formatData($req);

        return $sections;
    }

    public function addTeacher($datas)
    {
        // recuperer les données
        $firstName = $datas['firstName'];
        $lastName = $datas['name'];
        $gender = $datas['genre'];
        $nickname = $datas['nickName'];
        $origin = $datas['origin'];
        $section = $datas['section'];


        // Ajout de données avec requête préparée (requête paramétrée)
        $query = "INSERT INTO `t_teacher` (`idTeacher`,`teaFirstname`, `teaName`, `teaGender`, `teaNickname`, `teaOrigine`, `fkSection`) 
                  VALUES (DEFAULT,'$firstName', '$lastName', '$gender', '$nickname', '$origin', '$section');";

        $this->querySimpleExecute($query);
    }

    public function updateTeacher($datas)
    {
        // recuperer les données
        $idTeacher = $datas['idTeacher'];
        $firstName = $datas['firstName'];
        $lastName = $datas['name'];
        $gender = $datas['genre'];
        $nickname = $datas['nickName'];
        $origin = $datas['origin'];
        $section = $datas['section'][0];
         
        echo $idTeacher. " fhdjkhjkhv";

        echo "<pre>";
        var_dump($datas);
        echo "</pre>";
        // Ajout de données avec requête préparée (requête paramétrée)
        $query = "UPDATE `t_teacher` SET `teaFirstname` = '$firstName', `teaName` = '$lastName', `teaGender` = '$gender', ";
        $query .= " `teaNickname` = '$nickname', `teaOrigine` = '$origin', `fkSection` = '$section' WHERE `idTeacher` = $idTeacher";


        echo "<pre>";
        var_dump($query);
        echo "</pre>";

        $this->querySimpleExecute($query);
    }

    public function Login($datas)
    {
        $login = false;
        // recuperer les données
        $userName = $datas['user'];
        $password = $datas['password'];

        // Ajout de données avec requête préparée (requête paramétrée)
        $query = "SELECT * FROM `t_user`";
                  
        $req = $this->querySimpleExecute($query);
        $users = $this->formatData($req);

        foreach($users as $user){
            if($user[`useLogin`] == $userName){
                echo "giris basarili";
                $login = true;
                $_SESSION["currentUser"]["name"] = $user[`useLogin`];
                echo "<pre>";
                var_dump($_SESSION);
                echo "</pre>";
            }
        }
    }
    /*
    // Ajouter un utilisateur dans le base de données
    public function checkLogin($datas)
    {
        // à partir du login et password saisis par l'utilisateur
        // TODO : Validation des saisies utilisateur
        $useLogin = $datas['user'];
        $usePassword = $datas['password'];
        $query = "SELECT * FROM t_user where useLogin = :useLogin and usePassword = :usePassword";

        // Création de la requête SQL permettant de récupérer les informations de l'utilisateur
        // Exécution de la requête. A noter l'utilisation de la méthode ->query()
        $req = $this->connector->prepare($query);

        $req->bindValue('useLogin', $useLogin, PDO::PARAM_STR);
        $req->bindValue('usePassword', $usePassword, PDO::PARAM_STR);
        $req->execute();

        // // On convertit le résultat de la requête en tableau
        // $user = $req->fetchALL(PDO::FETCH_ASSOC);
        // // Si le tableau 'user' n'est pas vide, cela signifie que l'utilisateur a bien été trouvé en DB
        // if ($user) {
        //     // Ajout de données avec requête préparée (requête paramétrée)
        //     $query = "INSERT INTO `t_user` (`idUser`,`useLogin`, `usePassword`, `useAdministrator`) 
        //               VALUES (DEFAULT,'$useLogin', '$usePassword', 0);";

        //     $this->querySimpleExecute($query);
        // }
    }
    // + tous les autres m�thodes dont vous aurez besoin pour la suite (insertTeacher ... etc)
    */
}
