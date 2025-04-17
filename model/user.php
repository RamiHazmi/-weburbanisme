<?php
class user
{
    private $username;
    private $email;
    private $password;
    private $address;
    private $phone;
    private $role;
    
    
    public function __construct($username,$email,$password,$address,$phone,$role)
    {
       $this->username=$username;
       $this->email=$email;
       $this->password=$password;
       $this->address=$address;
       $this->phone=$phone;
       $this->role=$role;
    }
    

    public function getusername()
    {
        return $this->username;
    }
    public function getemail()
    {
        return $this->email;
    }
    public function getpassword()
    {
        return $this->password;
    }
    public function getaddress()
    {
        return $this->address;
    } 
    public function getphone()
    {
        return $this->phone;
    }
    public function getrole() {
        return $this->role;
    }

    public function setusername($username)
    {
        $this->username = $username;
    }
    public function setemail($email)
    {
        $this->email = $email;
    }
    public function setpassword($password)
    {
        $this->password = $password;
    }
    public function setaddress($address)
    {
        $this->address = $address;
    }
    public function setphone($phone)
    {
        $this->phone = $phone;
    }
    public function setrole($role) {
        $this->role = $role;
    }

}


?>