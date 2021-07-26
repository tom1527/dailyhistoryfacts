<!DOCTYPE HTML>

<?php
class DatabaseSearcher extends DataBaseConn {

    public $searchTerm; 
    public $sortBy; 
    public $pageNo;
    public $limitBy;

    public function __construct(array $searchTerms) {
        $this->searchTerms = $searchTerms;
    }

    public function getSearchResults(): array {
        $searchTerms = $this->searchTerms;
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$searchTerms['0']]);

        $results = $stmt->fetchAll();
        return $results;        
    }

    public function countSearchResults(): int {
        $searchTerms = $this->searchTerms;
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$searchTerms['0']]);
        
        $results = $stmt->fetchAll();
        $totalNumberOfSearchResults = count($results);
        return $totalNumberOfSearchResults;
    }
}