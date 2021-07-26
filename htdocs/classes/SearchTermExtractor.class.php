<?php
class SearchTermExtractor {
    private string $searchTerm;
    private string $sortBy;
    private int $pageNo;
    private int $limitBy;

    public function __construct(string $searchTerm, string $sortBy, int $pageNo, int $limitBy) {
        $this->searchTerm = $searchTerm;
        $this->sortBy = $sortBy;
        $this->pageNo = $pageNo;
        $this->limitBy = $limitBy;
    }

    public function extractSearchTerms(): array {
        $searchTerms = array();
        array_push($searchTerms, $this->searchTerm, $this->sortBy, $this->pageNo, $this->limitBy);
        
        return $searchTerms;
    }

}