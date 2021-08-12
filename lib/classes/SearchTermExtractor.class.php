<?php
class SearchTermExtractor {
    private string $searchTerm;
    private string $sortBy;
    private int $pageNo;
    private string $limitBy;

    public function __construct(string $searchTerm, string $sortBy, int $pageNo, int $limitBy) {
        $this->searchTerm = $searchTerm;
        $this->sortBy = $sortBy;
        $this->pageNo = $pageNo;
        $this->limitBy = $limitBy;
    }

    public function extractSearchTerms(): array {
        
        $this->offset = ($this->pageNo - 1) * $this->limitBy;
        
        $searchTerms = array();
        $searchTerms += ["searchTerm" => $this->searchTerm, "sortBy" => $this->sortBy, "limitBy" => $this->limitBy, "offset" => $this->offset];
        return $searchTerms;
    }

}