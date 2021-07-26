<?php


class ResultsDisplayer {

    private array $searchTerms;
    private array $results;
    private int $totalResults;

    public function __construct(array $searchTerms, array $results, int $totalResults) {
        $this->searchTerms = $searchTerms;
        $this->results = $results;
        $this->totalResults = $totalResults;
        
    }
    
    public function resultDisplayer(): void {
        $searchTerms = $this->searchTerms;
        $results = $this->results;
        $totalResults = $this->totalResults;
        

        echo "<div>Search of \"$searchTerms[searchTerm]\" returned $totalResults.</div>";
        foreach ($results as $i => $result) {
            $resultNumber = $i + 1;
            echo "<div class='archiveResults'>Result: $resultNumber";
            echo "<h4 class='result'>$result[day]/$result[month]</h4>";
            echo "<p class='result'>$result[fact]</p>";
    
            if($result['link']) {
                echo "<p>Click <a href='$result[link]' target='blank'>here</a> to learn more about this event.</p>";
            }
            if($result['image']) {
                echo "
                <a href='$result[image]' target='blank'>
                    <img src='$result[image]' alt='associated image' style='width:200px;height:200px'>
                </a>";
            }
            echo "</div>";
        }
    }
}
