<?php

namespace OpenModule\PhpCalendar\Calendars;

use Carbon\Carbon;
use IntlCalendar;

class HijriCalendar extends BaseCalendar implements CalendarInterface
{
    /**
     * تعداد روزهای هر ماه در سال های قمری
     * @var array|array[]
     */
    private static array $specialDays = [
        1440 => [30, 29, 30, 30, 30, 29, 30, 30, 29, 29, 30, 29], //355
        1441 => [29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30], // 355
        1442 => [29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29], // 354
        1443 => [29, 30, 30, 29, 29, 30, 29, 30, 30, 29, 30, 29], // 354
        1444 => [30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 29], // 354
        1445 => [30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 29],  //354
        1446 => [30, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29],  // 355
        1447 => [30, 29, 30, 30, 30, 29, 30, 29, 30, 29, 30, 29],  //355
        1448 => [29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30],  //355
        1449 => [29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29],  //354
        1450 => [30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29],
        1451 => [30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 29],
        1452 => [30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30],
        1453 => [29, 30, 30, 30, 29, 29, 30, 29, 30, 29, 30, 29],
        1454 => [29, 30, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30],
        1455 => [29, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 29],
        1456 => [30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 30],
        1457 => [29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30],
        1458 => [30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30],
        1459 => [30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29],
        1460 => [30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 30],
        1461 => [29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29],
        1462 => [30, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30],
        1463 => [29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29],
        1464 => [30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30],
        1465 => [29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 30],
        1466 => [30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30],
        1467 => [30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29],
        1468 => [30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30],
        1469 => [29, 29, 30, 30, 29, 30, 30, 29, 30, 30, 29, 29],
        1470 => [30, 29, 29, 30, 30, 29, 30, 29, 30, 30, 30, 29],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->calendar = IntlCalendar::createInstance(locale: 'en@calendar=islamic');
    }

    public function toCarbon(): Carbon
    {
        $this->addDay();
        return parent::toCarbon();
    }

    public static function now(): static
    {
        return parent::now()->addDays(-1);
    }

    public function isLeapYear(): bool
    {
        $kabiseReminders = [2, 5, 7, 10, 13, 16, 18, 21, 24, 26, 29];
        $r = $this->year % 30;
        return in_array($r, $kabiseReminders);
    }

    public function addDay(): static
    {
        parent::addDay();
        return $this->checkAddOrSubDay();
    }

    public function addDays(int $days = 1): static
    {
        parent::addDays($days);
        return $this->checkAddOrSubDay();
    }

    public function addMonth(): static
    {
        parent::addMonth();
        return $this->checkAddOrSubDay();
    }

    public function addMonths(int $months = 1): static
    {
        parent::addMonths($months);
        return $this->checkAddOrSubDay();
    }

    public function addYear(): static
    {
        parent::addYear();
        return $this->checkAddOrSubDay();
    }

    public function addYears(int $years = 1): static
    {
        parent::addYears($years);
        return $this->checkAddOrSubDay();
    }

    public function addHours(int $hours = 1): static
    {
        parent::addHours($hours);
        return $this->checkAddOrSubDay();
    }

    public function addMinutes(int $minutes = 1): static
    {
        parent::addMinutes($minutes);
        return $this->checkAddOrSubDay();
    }

    public function addSeconds(int $seconds = 1): static
    {
        parent::addSeconds($seconds);
        return $this->checkAddOrSubDay();
    }


    public function checkAddOrSubDay(): static
    {
        $yearOfPrevMonth = $this->getYear();
        $prevMonth = ($this->getMonth() - 1) % 12;
        if ($prevMonth == 0) {
            $prevMonth++;
            $yearOfPrevMonth--;
        }
        $prevMonthCalculated = $this->getPreviousMonthNumberOfDaysUsingCalendar();
        if ($prevMonthCalculated == static::$specialDays[$yearOfPrevMonth][$prevMonth - 1]) {
            return $this;
        } else {
            if ($prevMonthCalculated < static::$specialDays[$yearOfPrevMonth][$prevMonth - 1]) {
                return $this->subDaySpecial();
            } else {
                return $this;
            }
        }
    }

    private function subDaySpecial(): static
    {
        $currentDay = $this->dayOfMonth;
        if ($currentDay >= 2 && $currentDay <= 30) {
            $this->dayOfMonth--;
            return $this;
        }
        $numberOfDays = $this->getPrevMonthNumberOfDays();
        $this->dayOfMonth = $numberOfDays;
        $this->month--;
        if ($this->month == 0) {
            $this->month = 12;
            $this->year--;
        }
        return $this;
    }

    private function getCurrentMonthNumberOfDays()
    {
        if (in_array($this->year, array_keys(static::$specialDays))) {
            return static::$specialDays[$this->year][$this->month - 1];
        }
        return $this->calendar->getActualMaximum(IntlCalendar::FIELD_DAY_OF_MONTH);
    }

    private function getPrevMonthNumberOfDays()
    {
        $cal = clone $this->calendar;
        $cal->add(IntlCalendar::FIELD_MONTH, -1);
        $year = $cal->get(IntlCalendar::FIELD_YEAR);
        $month = $cal->get(IntlCalendar::FIELD_MONTH);
        if (in_array($year, array_keys(static::$specialDays))) {
            return static::$specialDays[$year][$month - 1];
        }
        return $cal->getActualMaximum(IntlCalendar::FIELD_DAY_OF_MONTH);
    }

    private function getPreviousMonthNumberOfDaysUsingCalendar(): int
    {
        $newCal = clone $this->calendar;
        $newCal->add(IntlCalendar::FIELD_MONTH, -1);
        return $newCal->getActualMaximum(IntlCalendar::FIELD_DAY_OF_MONTH);
    }

    public function diffInDays(CalendarInterface $calendar, bool $absolute = true): int
    {
        $start = $this;
        $end = $calendar;
        $sign = -1;
        if ($start->gt($end)) {
            $temp = $end->clone();
            $end = $start;
            $start = $temp;
            $sign = 1;
        }
        $diff = self::getYearDaysFromStart($end->getYear(), $end->getMonth(), $end->getDayOfMonth()) -
            self::getYearDaysFromStart($start->getYear(), $start->getMonth(), $start->getDayOfMonth());
        if (($diffYears = $end->getYear() - $start->getYear()) > 0) {
            for ($i = 1, $year = $start->getYear(); $i <= $diffYears; $i++, $year++) {
                $diff += self::getTotalYearDays($year);
            }
        }
        if (!$absolute) {
            $diff = $sign * $diff;
        }
        return $diff;
    }

    private static function getYearDaysFromStart(int $year, int $month, int $day): int
    {
        $count = $day;
        if ($month > 1) {
            $count += array_reduce(range(1, $month - 1), fn($c, $m) => $c + static::$specialDays[$year][$m - 1], 0);
        }
        return $count;
    }

    private static function getTotalYearDays(int $year): int
    {
        $monthWith30DaysCount = array_reduce(self::$specialDays[$year], function ($c, $days) use ($year) {
            if ($days == 30) {
                return $c + 1;
            }
            return $c;
        }, 0);
        if ($monthWith30DaysCount == 6) {
            return 354;
        }
        return 355;
    }

    public function getMonthNames(): array
    {
        return [
            'محرم',
            'صفر',
            'ربیع الاول',
            'ربیع الثانی',
            'جمادی الاول',
            'جمادی الثانی',
            'رجب',
            'شعبان',
            'رمضان',
            'شوال',
            'ذیقعده',
            'ذیحجه'
        ];
    }

    public function getMonthName(): string
    {
        return match ($this->getMonth()) {
            1 => 'محرم',
            2 => 'صفر',
            3 => 'ربیع الاول',
            4 => 'ربیع الثانی',
            5 => 'جمادی الاول',
            6 => 'جمادی الثانی',
            7 => 'رجب',
            8 => 'شعبان',
            9 => 'رمضان',
            10 => 'شوال',
            11 => 'ذیقعده',
            12 => 'ذیحجه',
        };
    }
}
