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
    
    


    public function getUserStats() {
        $sql = "SELECT status, COUNT(*) as count FROM user GROUP BY status";  // Compter les utilisateurs par statut
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialiser les variables pour les utilisateurs actifs et bloqués
            $activeCount = 0;
            $blockedCount = 0;

            // Parcourir les résultats pour obtenir les comptes actifs et bloqués
            foreach ($result as $row) {
                if ($row['status'] === 'active') {
                    $activeCount = $row['count'];
                } elseif ($row['status'] === 'blocked') {
                    $blockedCount = $row['count'];
                }
            }

            return ['active' => $activeCount, 'blocked' => $blockedCount];
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function getUserRegistrationsPerDay() {
        $sql = "SELECT DATE(created_at) AS date, COUNT(*) AS count
                FROM user
                GROUP BY DATE(created_at)
                ORDER BY DATE(created_at)";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    

}




?>