<?php

namespace OpenModule\PhpCalendar\Calendars;

class GregorianCalendar extends BaseCalendar implements CalendarInterface
{
    public function __construct($timezone='UTC')
    {
        parent::__construct($timezone);
        $this->calendar = \IntlCalendar::createInstance($timezone, 'en@calendar=gregorian');
    }

    public function isLeapYear(): bool
    {
        return $this->toCarbon()->isLeapYear();
    }

    public function getMonthNames(): array
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'Jun',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
    }

    public function getMonthName(): string
    {
       return match ($this->getMonth()){
           1 => 'January',
           2 => 'February',
           3 => 'March',
           4 => 'April',
           5 => 'May',
           6 => 'Jun',
           7 => 'July',
           8 => 'August',
           9 => 'September',
           10 => 'October',
           11 => 'November',
           12 => 'December'
       };
    }
}
