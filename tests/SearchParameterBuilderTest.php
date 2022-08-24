<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class BuildSearchParametersTest extends TestCase
{

    public function testBuildSearchParametersHasKeys(): void
    {
        $searchTerms = SearchParameterBuilder::buildSearchParameters("treaty", "dateDes", 1, 10);
        $this->assertArrayHasKey("searchTerm", $searchTerms, "\$searchTerms lacks the \"searchTerm\" key.");
        $this->assertArrayHasKey("sortBy", $searchTerms, "\$searchTerms lacks the \"searchTerm\" key.");
        $this->assertArrayHasKey("pageNo", $searchTerms, "\$searchTerms lacks the \"searchTerm\" key.");
        $this->assertArrayHasKey("maxResults", $searchTerms, "\$searchTerms lacks the \"searchTerm\" key.");
    }

    public function testBuildSearchParametersReturnsCorrectTypes(): void {
        $searchTerms = SearchParameterBuilder::buildSearchParameters("battle", "dateAsc", 2, 5);
        $this->assertIsString($searchTerms["searchTerm"]);
        $this->assertIsString($searchTerms["sortBy"]);
        $this->assertIsInt($searchTerms["pageNo"]);
        $this->assertIsInt($searchTerms["maxResults"]);
    }

    public function testBuildSearchParametersReturnsLimits() {
        $searchTerms = SearchParameterBuilder::buildSearchParameters("war", "---", 3, 15);
        $this->assertContains($searchTerms["maxResults"], [5, 10, 15, 20]);
    }
}



?>

