<?php

namespace OpenModule\PhpCalendar\Calendars;

use OpenModule\PhpCalendar\Exceptions\DatetimeInvalidException;
use Carbon\Carbon;
use IntlCalendar;
use OpenModule\PhpCalendar\Helpers\Helper;
use Throwable;

abstract class BaseCalendar implements CalendarInterface
{
    public ?string         $date;
    protected IntlCalendar $calendar;

    public int $year       = 0;
    public int $month      = 0;
    public int $dayOfMonth = 0;
    public int $hours      = 0;
    public int $minutes    = 0;
    public int $seconds    = 0;

    public string $timezone = 'UTC';

    protected const BASE_CONVERSION = [
        PersianCalendar::class   => '1397-07-19',
        HijriCalendar::class     => '1440-02-01',
        GregorianCalendar::class => '2018-10-11'
    ];

    public function __construct(string $timezone = 'UTC')
    {
        $this->timezone = $timezone;
    }

    public function setCalendar($timezone = 'UTC'): static
    {
        $this->calendar->set($this->year, $this->month - 1, $this->dayOfMonth, $this->hours, $this->minutes, $this->seconds);
        $this->calendar->setTimezone($timezone);
        $this->timezone = $timezone;
        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @throws DatetimeInvalidException
     * @throws Throwable
     */
    public function setDate(string $date, $timezone = 'UTC'): CalendarInterface
    {
        $this->date = $date;
        $res = preg_match('/^(\d{4})\W(0[1-9]|1[012]|[1-9])\W(0[1-9]|[1,2][0-9]|3[01]|[1-9])\s?(([0-1][0-9]|2[0-3]|[0-9])\W([0-5][0-9]|[0-9])\W([0-5][0-9]|[0-9]))?$/', $date, $parts);
        if (!$res) {
            throw new DatetimeInvalidException();
        }
        [$this->year, $this->month, $this->dayOfMonth, $this->hours, $this->minutes, $this->seconds] =
            [Helper::option($parts, 1, 0), Helper::option($parts, 2, 0), Helper::option($parts, 3, 0), Helper::option($parts, 4, 0), Helper::option($parts, 5, 0), Helper::option($parts, 6, 0)];
        $this->setCalendar($timezone);
        return $this;
    }

    public function timezone($timezone = 'UTC'): CalendarInterface
    {
        $this->calendar->setTimeZone($timezone);
        $this->timezone = $timezone;
        $this->setDateFromCalendar();
        return $this;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getDayOfMonth(): int
    {
        return $this->dayOfMonth;
    }

    public function getHours(): int
    {
        return $this->hours;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function addDay(): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addDays(int $days = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_DAY_OF_MONTH, $days);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addMonth(): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_MONTH, 1);
        $this->calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, $this->dayOfMonth);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addMonths(int $months = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_MONTH, $months);
        $this->calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, $this->dayOfMonth);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addYear(): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_YEAR, 1);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addYears(int $years = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_YEAR, $years);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addHours(int $hours = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_HOUR, $hours);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addMinutes(int $minutes = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_MINUTE, $minutes);
        $this->setDateFromCalendar();
        return $this;
    }

    public function addSeconds(int $seconds = 1): static
    {
        $this->calendar->add(\IntlCalendar::FIELD_SECOND, $seconds);
        $this->setDateFromCalendar();
        return $this;
    }

    /**
     * get the start of month by specific calendar
     * @return BaseCalendar
     */
    public function getStartOfMonth(): CalendarInterface
    {
        $calendarCopy = $this->clone();
        $calendar = $calendarCopy->calendar;
        $calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $calendarCopy->setDateFromCalendar();
        return $calendarCopy;
    }

    public function setYear(int $year): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_YEAR, $year);
        $this->setDateFromCalendar();
        return $this;
    }

    public function setMonth(int $month): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_MONTH, $month);
        $this->setDateFromCalendar();
        return $this;
    }

    public function setDayOfMonth(int $dayOfMonth): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, $dayOfMonth);
        $this->setDateFromCalendar();
        return $this;
    }

    public function setHours(int $hours): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_HOUR, $hours);
        $this->setDateFromCalendar();
        return $this;
    }

    public function setMinutes(int $minutes): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_MINUTE, $minutes);
        $this->setDateFromCalendar();
        return $this;
    }

    public function setSeconds(int $seconds): CalendarInterface
    {
        $this->calendar->set(\IntlCalendar::FIELD_SECOND, $seconds);
        $this->setDateFromCalendar();
        return $this;
    }

    /**
     * get the end of month by specific calendar
     * @return CalendarInterface
     */
    public function getEndOfMonth(): CalendarInterface
    {
        $calendarCopy = $this->clone();
        $calendar = $calendarCopy->calendar;
        $calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $calendar->add(\IntlCalendar::FIELD_MONTH, 1);
        $calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, 0);
        $calendarCopy->setDateFromCalendar();
        return $calendarCopy;
    }

    /**
     * get the start of year by specific calendar
     * @return CalendarInterface
     */
    public function getStatOfYear(): CalendarInterface
    {
        $calendarCopy = $this->clone();
        $calendar = $calendarCopy->calendar;
        $calendar->set(\IntlCalendar::FIELD_MONTH, 0);
        $calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $calendarCopy->setDateFromCalendar();
        return $calendarCopy;
    }

    /**
     * get the end of year by specific calendar
     * @return CalendarInterface
     */
    public function getEndOfYear(): CalendarInterface
    {
        $calendarCopy = $this->clone();
        $calendar = $calendarCopy->calendar;
        $calendar->set(\IntlCalendar::FIELD_MONTH, 0);
        $calendar->add(\IntlCalendar::FIELD_YEAR, 1);
        $calendar->set(\IntlCalendar::FIELD_DAY_OF_MONTH, 0);
        $calendarCopy->setDateFromCalendar();
        return $calendarCopy;
    }

    public function format(string $format = 'Y-m-d'): string
    {
        return str_replace(['Y', 'm', 'd', 'H', 'i', 's'], [
            $this->getYear(),
            str_pad($this->getMonth(), 2, '0', STR_PAD_LEFT),
            str_pad($this->getDayOfMonth(), 2, '0', STR_PAD_LEFT),
            str_pad($this->getHours(), 2, '0', STR_PAD_LEFT),
            str_pad($this->getMinutes(), 2, '0', STR_PAD_LEFT),
            str_pad($this->getSeconds(), 2, '0', STR_PAD_LEFT),
        ], $format);
    }

    public function clone(): BaseCalendar|static
    {
        return clone $this;
    }

    public function setDateFromCalendar(): void
    {
        $this->year = $this->calendar->get(\IntlCalendar::FIELD_YEAR);
        $this->month = $this->calendar->get(\IntlCalendar::FIELD_MONTH) + 1;
        $this->dayOfMonth = $this->calendar->get(\IntlCalendar::FIELD_DAY_OF_MONTH);
        $this->hours = $this->calendar->get(\IntlCalendar::FIELD_HOUR);
        $this->minutes = $this->calendar->get(\IntlCalendar::FIELD_MINUTE);
        $this->seconds = $this->calendar->get(\IntlCalendar::FIELD_SECOND);
        $this->date = $this->format('Y-m-d H:i:s');
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function to(CalendarInterface $calendar): CalendarInterface
    {
        if ($calendar instanceof $this) {
            return $this;
        }
        $baseFrom = self::BASE_CONVERSION[$this::class];
        $baseTo = self::BASE_CONVERSION[$calendar::class];
        [$hour, $min, $sec] = [$this->getHours(), $this->getMinutes(), $this->getSeconds()];
        $diffDays = $this->diffInDays($this::fromDate($baseFrom, $this->timezone));
        $calendar->setDate($baseTo, $calendar->timezone);
        $calendar->addDays($diffDays);
        $calendar->setHours($hour);
        $calendar->setMinutes($min);
        $calendar->setSeconds($sec);
        return $calendar;
    }

    public function getTime(): float|bool
    {
        return $this->calendar->getTime();
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function setTime(float $time): CalendarInterface
    {
        $res = $this->calendar->setTime($time);
        if ($res) {
            $this->setDateFromCalendar();
            return $this;
        }
        throw new DatetimeInvalidException();
    }

    public static function fromDate(CalendarInterface|string $date, $timezone = 'UTC'): CalendarInterface
    {
        if ($date instanceof CalendarInterface) {
            return $date->clone();
        }
        return (new static($timezone))->setDate($date, $timezone);
    }

    public static function getRange($start, $end): array
    {
        return [
            GregorianCalendar::fromDate($start)->to(new static()),
            GregorianCalendar::fromDate($end)->to(new static())
        ];
    }

    /**
     * @throws DatetimeInvalidException
     */
    public static function fromTimestamp(float $timestamp): CalendarInterface
    {
        $instance = new static();
        $instance->setTime($timestamp);
        return $instance;
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function diffInYears(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInYears($convertCalendar, $absolute);
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function diffInMonths(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInMonths($convertCalendar, $absolute);
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function diffInDays(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInDays($convertCalendar, $absolute);
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function diffInHours(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInHours($convertCalendar, $absolute);
    }

    public function diffInMinutes(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInMinutes($convertCalendar, $absolute);
    }

    /**
     * @throws DatetimeInvalidException
     */
    public function diffInSeconds(CalendarInterface $calendar, bool $absolute = true): int
    {
        if (!($calendar instanceof $this)) {
            throw new DatetimeInvalidException();
        }
        $convertThis = $this->toCarbon();
        $convertCalendar = $calendar->toCarbon();
        return $convertThis->diffInSeconds($convertCalendar, $absolute);
    }

    public function toCarbon(): Carbon
    {
        return Carbon::parse($this->calendar->toDateTime());
    }

    /**
     * @throws DatetimeInvalidException
     */
    public static function now($timezone = 'UTC'): static
    {
        $instance = new static();
        $instance->calendar->setTimeZone($timezone);
        $instance->timezone = $timezone;
        $instance->setTime(\IntlCalendar::getNow());
        return $instance;
    }

    public function lt(CalendarInterface $calendar): bool
    {
        return $this->getTime() < $calendar->getTime();
    }

    public function lte(CalendarInterface $calendar): bool
    {
        return $this->getTime() <= $calendar->getTime();
    }

    public function gt(CalendarInterface $calendar): bool
    {
        return $this->getTime() > $calendar->getTime();
    }

    public function gte(CalendarInterface $calendar): bool
    {
        return $this->getTime() >= $calendar->getTime();
    }

    public function eq(CalendarInterface $calendar): bool
    {
        return $this->format() == $calendar->format();
    }
}
