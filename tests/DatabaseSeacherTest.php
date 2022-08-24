<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class DatabaseSearcherTest extends TestCase
{
    public function testGetSearchResultsReturnsArray(): void {
        $searchTerms = ["searchTerm" => "treaty", "sortBy" => "dateASC", "pageNo" => 1, "maxResults" => 5];
        $pdo = DatabaseConn::connect();
        $databaseSearcher = new DatabaseSearcher($pdo);
        $results = $databaseSearcher->getSearchResults($searchTerms);
        $this->assertIsArray($results);
    }
}



?>

