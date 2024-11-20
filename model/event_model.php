<?php //ytaaml maa lbase de donnee mteey 
class EventModel {// modéle yhez tous les events ili aandi lkol yhothom fi site 
    private $db;// maaneha tab y5oss kn events 

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllEvents() { //taatyk tous les events elmwjoudin fi tab lkol
        $query = "SELECT * FROM event";//  ya3tini tab events lkol ou ili fyh lkol id nom date ect
        $statement = $this->db->prepare($query);//y7adher requette
        $statement->execute();// yexecutti requette 
        return $statement->fetchAll(PDO::FETCH_ASSOC);//ireturni el requette mte3ou
    }
}

?>
