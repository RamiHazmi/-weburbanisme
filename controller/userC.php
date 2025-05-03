<?php
include_once __DIR__ . '/../database.php';

class userC
{
    public function ajouter($user)
{
    $sql = "INSERT INTO user (username, email, password, address, phone, role, status) 
            VALUES (:username, :email, :password, :address, :phone, :role,:status)";

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
            ':status' => $user->getStatus() 
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
        $sql = "UPDATE user SET username = :username, email = :email, password = :password, address = :address, phone = :phone, role = :role, status = :status WHERE id = :id";
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
                'status' => $user->getStatus(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    function rechercher($id){
        $sql = "SELECT * from user where id = :id"; 
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
    
            $user = $query->fetch();
            return $user;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    
    public function modifierPassword($id, $hashedPassword) {
            $sql = "UPDATE user SET password = :password WHERE id = :id";
            $db = config::getConnexion();
            try {
                $query = $db->prepare($sql);
                $query->execute([
                    'password' => $hashedPassword,  
                    'id' => $id
                ]);
            } catch (Exception $e) {
                echo "Erreur: " . $e->getMessage();
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