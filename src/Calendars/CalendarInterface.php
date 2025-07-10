<?php

namespace OpenModule\PhpCalendar\Calendars;

use Carbon\Carbon;

interface CalendarInterface
{

    public function timezone($timezone='UTC'): CalendarInterface;

    public function getTimezone();
    public function getDate(): ?string;

    public function setDate(string $date): CalendarInterface;

    public function addDay(): CalendarInterface;

    public function addDays(int $days = 1): CalendarInterface;

    public function addMonth(): CalendarInterface;

    public function addMonths(int $months = 1): CalendarInterface;

    public function addYear(): CalendarInterface;

    public function addYears(int $years = 1): CalendarInterface;

    public function addHours(int $hours = 1): CalendarInterface;

    public function addMinutes(int $minutes = 1): CalendarInterface;

    public function addSeconds(int $seconds = 1): CalendarInterface;

    public function getYear(): int;

    public function getMonth(): int;

    public function getDayOfMonth(): int;

    public function getHours(): int;

    public function getMinutes(): int;

    public function getSeconds(): int;

    public function setYear(int $year): CalendarInterface;

    public function setMonth(int $month): CalendarInterface;

    public function setDayOfMonth(int $dayOfMonth): CalendarInterface;

    public function setHours(int $hours): CalendarInterface;

    public function setMinutes(int $minutes): CalendarInterface;

    public function setSeconds(int $seconds): CalendarInterface;

    public function getStartOfMonth(): CalendarInterface;

    public function getEndOfMonth(): CalendarInterface;

    public function getStatOfYear(): CalendarInterface;

    public function getEndOfYear(): CalendarInterface;

    public function format(string $format = 'Y-m-d'): string;

    public function setCalendar(): CalendarInterface;

    /**
     * convert current calendar to another
     * @param CalendarInterface $calendar
     * @return CalendarInterface
     */
    public function to(CalendarInterface $calendar): CalendarInterface;

    /**
     * get the timestamp from object
     * @return float|bool
     */
    public function getTime(): float|bool;

    /**
     * set the timestamp for this object
     * @param float $time
     * @return CalendarInterface
     */
    public function setTime(float $time): CalendarInterface;

    public static function fromDate(string|CalendarInterface $date): CalendarInterface;

    public static function getRange($start, $end): array;

    public static function fromTimestamp(float $timestamp): CalendarInterface;

    public function diffInDays(CalendarInterface $calendar, bool $absolute = true): int;

    public function diffInMonths(CalendarInterface $calendar, bool $absolute = true): int;

    public function diffInYears(CalendarInterface $calendar, bool $absolute = true): int;

    public function diffInHours(CalendarInterface $calendar, bool $absolute = true): int;
    public function diffInMinutes(CalendarInterface $calendar, bool $absolute = true): int;

    public function diffInSeconds(CalendarInterface $calendar, bool $absolute = true): int;

    public function toCarbon():Carbon;

    public static function now(): static;

    public function lt(CalendarInterface $calendar): bool;

    public function lte(CalendarInterface $calendar): bool;

    public function gt(CalendarInterface $calendar): bool;

    public function gte(CalendarInterface $calendar): bool;

    public function eq(CalendarInterface $calendar): bool;

    public function isLeapYear():bool;

    public function getMonthNames():array;

    public function getMonthName():string;
}
