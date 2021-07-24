<!DOCTYPE HTML>

<?php
class DatabaseSearcher extends DataBaseConn {
    private $searchTerm;
    private $sortBy;
    private $pageNo;
    private $limitBy;

    public function __construct(string $searchTerm, string $sortBy, int $pageNo, int $limitBy)
    {
        $this->searchTerm = $searchTerm;
        $this->sortBy = $sortBy;
        $this->pageNo = $pageNo;
        $this->limitBy = $limitBy;
    }

    public function getSearchResults(): array {
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->searchTerm]);

        $results = $stmt->fetchAll();
        return $results;        
    }

    public function countSearchResults(): int {
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->searchTerm]);
        
        $results = $stmt->fetchAll();
        $totalNumberOfSearchResults = count($results);
        return $totalNumberOfSearchResults;
    }
}