<?php

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {

        if($_SERVER['REQUEST_METHOD']==='POST') {

            if($_POST['csrf_token']!==$_SESSION['csrf_token']) die("CSRF Error");

            $data = [
                'nom'=>trim($_POST['nom']),
                'prenom'=>trim($_POST['prenom']),
                'email'=>trim($_POST['email']),
                'sexe'=>$_POST['sexe'],
                'date_naissance'=>$_POST['date_naissance'],
                'adresse'=>trim($_POST['adresse']),
                'password'=>$_POST['password']
            ];

            if($data['password']!==$_POST['confirm_password']) {
                $errors[]="Les mots de passe ne correspondent pas";
                require '../app/views/users/register.php';
                return;
            }

            if($this->userModel->findByEmail($data['email'])) {
                $errors[]="Email déjà utilisé";
                require '../app/views/users/register.php';
                return;
            }

            $this->userModel->create($data);
            header("Location: index.php?url=login");
            exit;
        }
    }

    public function login() {

        if($_SERVER['REQUEST_METHOD']==='POST') {

            if($_POST['csrf_token']!==$_SESSION['csrf_token']) die("CSRF Error");

            $user = $this->userModel->findByEmail(trim($_POST['email']));

            if($user && password_verify($_POST['password'],$user['password'])) {

                session_regenerate_id(true);

                $_SESSION['user_id']=$user['id'];
                $_SESSION['user_role']=$user['role'];
                $_SESSION['user']=$user;
                unset($_SESSION['user']['password']);
                header("Location: index.php?url=challenges");
                exit;
            }

            $errors[]="Informations incorrectes";
            require '../app/views/users/login.php';
        }
    }

    public function profile() {

        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $user=$this->userModel->findById($_SESSION['user_id']);
        require '../app/views/users/profile.php';
    }

    public function edit() {

        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $user=$this->userModel->findById($_SESSION['user_id']);
        require '../app/views/users/edit.php';
    }

    public function update() {

        if($_POST['csrf_token']!==$_SESSION['csrf_token']) die("CSRF Error");

        $this->userModel->update($_SESSION['user_id'],[
            'nom'=>trim($_POST['nom']),
            'prenom'=>trim($_POST['prenom']),
            'email'=>trim($_POST['email']),
            'sexe'=>$_POST['sexe'],
            'date_naissance'=>$_POST['date_naissance'],
            'adresse'=>trim($_POST['adresse'])
        ]);

        header("Location: index.php?url=profile");
    }

    public function delete() {
        $this->userModel->delete($_SESSION['user_id']);
        session_destroy();
        header("Location: index.php?url=register");
    }
}