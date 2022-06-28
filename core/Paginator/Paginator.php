<?php


namespace core\Paginator;



class Paginator implements PaginatorInterface
{
    private static int $totalElements;

    private static int $elementsPerPage;

    private static int $numOfDisplayedPages;

    public static function getPages(): array
    {
        $maxPages = self::getNumOfPages() > self::getNumOfDisplayedPages() ? self::getNumOfDisplayedPages() : self::getNumOfPages();
        $startRange = self::getCurrentPage() - 4;
        $endRange = self::getCurrentPage() + 5;

        if ($startRange < 1) {
            $startRange = 1;
            $endRange = $maxPages;
        }

        if (self::getCurrentPage() + 5 > self::getNumOfPages()) {
            $endRange = self::getNumOfPages();
        }

        return range($startRange, $endRange);
    }

    public static function getNumOfPages(): int
    {
        return ceil(self::$totalElements / self::$elementsPerPage);
    }

    public static function getCurrentPage(): int
    {
         return isset($_GET["page"]) && ($_GET["page"] > 0) ? $_GET["page"] : 1;
    }

    public static function getNumOfDisplayedPages(): int
    {
        return self::$numOfDisplayedPages;
    }

    public static function setNumOfDisplayedPages(int $pages = 10): void
    {
        self::$numOfDisplayedPages = $pages;
    }

    public static function setTotalElements(int $totalElements)
    {
        self::$totalElements = $totalElements;
    }

    public static function setElementsPerPage(int $num)
    {
        self::$elementsPerPage = $num;
    }

    public static function init(): string
    {
        $startingElement = 0;

        if (self::getCurrentPage() !== 1) {
            $startingElement = (self::getCurrentPage() - 1) * self::$elementsPerPage;
        }

        return " LIMIT $startingElement, " . self::$elementsPerPage;
    }
}