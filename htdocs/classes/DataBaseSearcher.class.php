<!DOCTYPE HTML>

<?php
class DatabaseSearcher extends DataBaseConn {

    public array $searchTerms; 

    public function __construct(array $searchTerms) {
        $this->searchTerms = $searchTerms;
    }

    public function getSearchResults(): array {
        $searchTerms = $this->searchTerms;
        $this->sortBy = $searchTerms['sortBy'];
        $this->limit = $searchTerms['limitBy'];
        $this->offset = $searchTerms['offset'];
 
        switch($this->sortBy){
            case "dateASC":
                $this->sortBy = "`day` ASC, `month` ASC";
                break;
            case "dateDES":
                $this->sortBy = "`day` DESC, `month` DESC";
                break;
            case "---":
                $this->sortBy = "NULL";
                break;
        }

        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', :searchTerm, '%') ORDER BY $this->sortBy Limit $this->limit OFFSET $this->offset";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerms['searchTerm']);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;        
    }

    public function countSearchResults(): int {
        $searchTerms = $this->searchTerms;
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$searchTerms['searchTerm']]);
        
        $results = $stmt->fetchAll();
        $totalNumberOfSearchResults = count($results);
        return $totalNumberOfSearchResults;
    }

    public function returnDailyFact($currentDay, $currentMonth): array {

        $sql = "SELECT * FROM facts WHERE day = '$currentDay' && month = '$currentMonth' ORDER BY RAND()";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;
    }
}