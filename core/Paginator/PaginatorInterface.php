<?php


namespace core\Paginator;


interface PaginatorInterface
{
    public static function getPages(): array;

    public static function getNumOfPages(): int;

    public static function getCurrentPage(): int;

    public static function getNumOfDisplayedPages(): int;

    public static function setNumOfDisplayedPages(int $pages = 10): void;

    public static function setElementsPerPage(int $num);

    public static function setTotalElements(int $totalElements);

    public static function init(): string;
}