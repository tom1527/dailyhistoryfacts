<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class BuildSearchParametersTest extends TestCase
{

    public function testBuildSearchParametersHasKeys(): void
    {
        $searchTerms = SearchParameterBuilder::buildSearchParameters("treaty", "dateDes", 1, 10);
        $this->assertArrayHasKey("searchTerm", $searchTerms, "\$searchTerms lacks the \"searTerm\" key.");
        $this->assertArrayHasKey("sortBy", $searchTerms, "\$searchTerms lacks the \"searTerm\" key.");
        $this->assertArrayHasKey("pageNo", $searchTerms, "\$searchTerms lacks the \"searTerm\" key.");
        $this->assertArrayHasKey("maxResults", $searchTerms, "\$searchTerms lacks the \"searTerm\" key.");
    }

    public function testBuildSearchParametersSubsets(): void
    {
        $searchTerms = SearchParameterBuilder::buildSearchParameters("treaty", "dateDes", 1, 10);
        $subset = array("searchTerm" => "treaty");
        $this->assertArraySubset($subset, $searchTerms, true, "searchTerms lacks subset as a subset");
    }
}



?>

