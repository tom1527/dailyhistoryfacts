<?php


class ResultsDisplayer {

    private DatabaseSearcher $searcher;
    private SearchTermExtractor $extractor;
    

    public function __construct($searcher, $extractor) {
        $this->searcher = $searcher;
        $this->extractor = $extractor;
    }
    
    public function displayResults(): void {
        
        $results = $this->searcher->getSearchResults();
        $totalResults = $this->searcher->countSearchResults();
        $searchTerm = $this->extractor->extractSearchTerms();
        

        echo "<div>Search of \"$searchTerm[0]\" returned $totalResults.</div>";
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
