<!DOCTYPE HTML>

<?php
class DatabaseSearcher {

    public static function getSearchResults(array $searchTerms): array {
        $searchTerms = $searchTerms;
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
        $stmt = DataBaseConn::connect()->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerms['searchTerm']);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;        
    }

    public static function countSearchResults(): int {
        $searchTerms = $searchTerms;
        $sql = "SELECT * FROM `facts` WHERE `fact` LIKE CONCAT('%', ?, '%')";
        $stmt = DataBaseConn::connect()->prepare($sql);
        $stmt->execute([$searchTerms['searchTerm']]);
        
        $results = $stmt->fetchAll();
        $totalNumberOfSearchResults = count($results);
        return $totalNumberOfSearchResults;
    }

    public static function returnDailyFact($currentDay, $currentMonth): array {

        if(strlen($currentDay) == 1) {
            $currentDay = "0".$currentDay;
        }

        if(strlen($currentMonth) == 1) {
            $currentMonth = "0".$currentMonth;
        }

        $sql = "SELECT * FROM facts WHERE day = '$currentDay' && month = '$currentMonth' ORDER BY RAND()";
        $stmt = DataBaseConn::connect()->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;
    }
}