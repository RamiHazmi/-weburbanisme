<?php
require __DIR__ . '/../config.php';

class userC
{
    public function ajouter($user)
{
    $sql = "INSERT INTO user (username, email, password, address, phone, role) 
            VALUES (:username, :email, :password, :address, :phone, :role)";

    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);


        $query->execute([
            'username' => $user->getusername(),
            'email' => $user->getemail(),
            'password' => $user->getpassword(),
            'address' => $user->getaddress(),
            'phone' => $user->getphone(),
            'role' => $user->getrole()
        ]);

        return true; 
    } catch (Exception $e) 
    {
        echo 'Erreur: ' . $e->getMessage();
        return false; 
    }
}

    


    public function afficher(){
        $sql="SELECT * FROM user";
        $db = config::getConnexion();
        try
        {
            $liste = $db->query($sql);
            return $liste;
        }
        catch(Exception $e){
            die('Erreur:'. $e->getMessage());
        }
    }


    function supprimer($id){
        $sql="DELETE FROM user WHERE id=:id";
        $db = config::getConnexion();
        $req=$db->prepare($sql);
        $req->bindValue(':id', $id);
        try{
            $req->execute();
        }
        catch(Exception $e){
            die('Erreur:'. $e->getMessage());
        }
    }



    function modifier($user, $id) {
        $sql = "UPDATE user SET username = :username, email = :email, password = :password, address = :address, phone = :phone, role = :role WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'username' => $user->getusername(),
                'email' => $user->getemail(),
                'password' => $user->getpassword(),
                'address' => $user->getaddress(),
                'phone' => $user->getphone(),
                'role' => $user->getrole(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }


    public function connexionUser($email, $password)
    {
        $db = config::getConnexion();
        
        try {
            $query = $db->prepare("SELECT * FROM user WHERE email = :email");
            $query->bindParam(':email', $email);
            $query->execute();
        
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    return "Connexion réussie";
                } else {
                    return "mot de passe incorrect";
                }
            } else {
                return "Utilisateur non trouvé";
            }
        } catch (Exception $e) {
            return "Erreur : " . $e->getMessage();
        }
}


    public function getUserByEmail($email) 
    {
        $db = config::getConnexion();
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM user WHERE id = ?";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateUser($id, $username,$email, $address, $phone ,$password) {
        $sql = "UPDATE user SET username = ?, email=? ,address = ?, phone = ? , password =? WHERE id = ?";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([$username,$email, $address, $phone, $password, $id]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    
    



}




?>