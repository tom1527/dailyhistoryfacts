<!DOCTYPE HTML>

<?php
class DatabaseSearcher {
    private PDO $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSearchResults(array $searchTerms): array {
        $sortBy = $searchTerms['sortBy'];
        $limit = $searchTerms['limitBy'];
        $offset = $searchTerms['offset'];
 
        switch($sortBy){
            case "dateASC":
                $sortBy = "`month` ASC, `day` ASC";
                break;
            case "dateDES":
                $sortBy = "`month` DESC, `day` DESC";
                break;
            case "---":
                $sortBy = "NULL";
                break;
        }

        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', :searchTerm, '%') ORDER BY $sortBy Limit $limit OFFSET $offset";
        // $stmt = DatabaseConn::connect()->prepare($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerms['searchTerm']);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;        
    }

    public function countSearchResults(array $searchTerms): int {
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        // $stmt = DatabaseConn::connect()->prepare($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerms['searchTerm']]);
        
        $results = $stmt->fetchAll();
        $totalNumberOfSearchResults = count($results);
        return $totalNumberOfSearchResults;
    }

    public function returnDailyFact($currentDay, $currentMonth): array {

        if(strlen($currentDay) == 1) {
            $currentDay = "0".$currentDay;
        }

        if(strlen($currentMonth) == 1) {
            $currentMonth = "0".$currentMonth;
        }

        $sql = "SELECT * FROM facts WHERE day = '$currentDay' && month = '$currentMonth' ORDER BY RAND()";
        // $stmt = DatabaseConn::connect()->prepare($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;
    }
}