    <?php
class utilisateur
{
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $define;
}
public function __construct($nom,$prenom,$email,$password,$define)
{
    this->$nom=$nom;
    this->$prenom=$prenom;
    this->$email=$email;
    this->$password=$password;
    this->$define=$define;
}
public function getNom()

{ 
    return this->$nom=$nom;
}
    public function getprenom()
{
    return this->$prenom=$prenom;
}
    public function getemail()
{
    return this->$email=$email;
}
public function getpassword()
{
    return this->$password=$password;
}
    public function getdefine()
    {

    
    return this->$define=$define;
}

?>