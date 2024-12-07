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

        foreach($binds as $bind) {
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
    private function unsetData($req)
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


        // Ajout de données avec requête préparée (requête paramétrée)
        $query = "INSERT INTO `t_teacher` (`idTeacher`,`teaFirstname`, `teaName`, `teaGender`, `teaNickname`, `teaOrigine`, `fkSection`) 
                  VALUES (DEFAULT,'$firstName', '$lastName', '$gender', '$nickname', '$origin', '$section');";

        // ????? Permet de préparer et d'exécuter une requéte de type prepare avec WHERE
        $this->querySimpleExecute($query);
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
        $query = "UPDATE `t_teacher` SET `teaFirstname` = '$firstName', `teaName` = '$lastName', `teaGender` = '$gender', ";
        $query .= " `teaNickname` = '$nickname', `teaOrigine` = '$origin', `fkSection` = '$section' WHERE `idTeacher` = $idTeacher";

        // ?????? Permet de préparer et d'exécuter une requéte de type prepare avec WHERE
        $this->querySimpleExecute($query);
    }

    // public function Login($datas)
    // {
    //     $login = false;
    //     // recuperer les données
    //     $userName = $datas['user'];
    //     $password = $datas['password'];

    //     // Ajout de données avec requête préparée (requête paramétrée)
    //     $query = "SELECT * FROM `t_user`";
                  
    //     $req = $this->querySimpleExecute($query);
    //     $users = $this->formatData($req);

    //     foreach($users as $user){
    //         if($user[`useLogin`] == $userName){
    //             echo "giris basarili";
    //             $login = true;
    //             $_SESSION["currentUser"]["name"] = $user[`useLogin`];
    //             echo "<pre>";
    //             var_dump($_SESSION);
    //             echo "</pre>";
    //         }
    //     }
    // }
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
