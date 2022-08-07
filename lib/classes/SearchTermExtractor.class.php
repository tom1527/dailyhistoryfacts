<?php
class SearchTermExtractor {
    private string $searchTerm;
    private string $sortBy;
    private int $pageNo;
    private int $limitBy;

    public static function extractSearchTerms(string $searchTerm, string $sortBy, int $pageNo, int $limitBy): array {
        
        $offset = ($pageNo - 1) * $limitBy;
        
        $searchTerms = array();
        $searchTerms += ["searchTerm" => $searchTerm, "sortBy" => $sortBy, "limitBy" => $limitBy, "offset" => $offset];
        return $searchTerms;
    }

}