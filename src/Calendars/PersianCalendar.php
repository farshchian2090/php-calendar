<?php

namespace OpenModule\PhpCalendar\Calendars;

class PersianCalendar extends BaseCalendar implements CalendarInterface
{
    public function __construct($timezone='UTC')
    {
        parent::__construct($timezone);
        $this->calendar = \IntlCalendar::createInstance($timezone, 'en@calendar=persian');
    }

    public function isLeapYear(): bool
    {
        $reminders = [1, 5, 9, 13, 17, 22, 26, 30];
        return in_array($this->year % 33, $reminders);
    }

    public function getMonthNames(): array
    {
        return [
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند'
        ];
    }

    public function getMonthName(): string
    {
        return match($this->getMonth()) {
            1 => 'فروردین',
            2 => 'اردیبهشت',
            3 => 'خرداد',
            4 => 'تیر',
            5 => 'مرداد',
            6 => 'شهریور',
            7 => 'مهر',
            8 => 'آبان',
            9 => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        };
    }
}
