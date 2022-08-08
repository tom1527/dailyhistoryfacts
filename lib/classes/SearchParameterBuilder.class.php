<?php
class SearchParameterBuilder {

    public static function buildSearchParameters(string $searchTerm, string $sortBy, int $pageNo, int $maxResults): array {
        
        return ["searchTerm" => $searchTerm, "sortBy" => $sortBy, "pageNo" => $pageNo, "maxResults" => $maxResults];
    }

}
