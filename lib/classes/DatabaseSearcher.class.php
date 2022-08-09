<?php
class DatabaseSearcher {
    private PDO $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSearchResults(array $searchTerms): array {
        $sortBy = $searchTerms['sortBy'];
        $maxResults = $searchTerms['maxResults'];
        $pageNo = $searchTerms['pageNo'];

        switch($sortBy){
            case "dateASC":
                $sortBy = "ORDER BY `month` ASC, `day` ASC";
                break;
            case "dateDES":
                $sortBy = "ORDER BY `month` DESC, `day` DESC";
                break;
            default:
                $sortBy = null;
                break;
        }

        $limitBySQLClause = empty($maxResults) ? "" : "LIMIT $maxResults";

        $offsetSQLClause = empty($maxResults) ? "" : "OFFSET " . $this->calculateOffset($pageNo, $maxResults);

        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', :searchTerm, '%') $sortBy $limitBySQLClause $offsetSQLClause";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerms['searchTerm']);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;        
    }

    public function countSearchResults(array $searchTerms): int {
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
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
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;
    }

    private function calculateOffset($pageNo, $maxResults) {
        return ($pageNo - 1) * $maxResults;
    }
}