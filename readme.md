### **Global Calendars Package (PersianCalendar - GregorianCalendar - HijriCalendar)**

this package is a php calendar package that supports PersianCalendar, GregorianCalendar and HijriCalendar

Using this package, you can easily convert Gregorian, solar, and hijri dates to each other, and also calculate operations in any calendar, such as adding days or years or the difference between two dates in terms of days, minutes, and seconds, etc., just like the carbon package.

### How to install:

```
composer require open_module/php-calendar
```

### requirements:
- PHP 8.0 or later
- enable Intl extension of php

### **How to use:**

```php
$calendar= PersianCalendar::fromDate('1404-04-20', 'Asia/Tehran'); 


$dayOfMonth=$calendar->getDayOfMonth(); // 20 
$month = $calendar->getMonth(); // 4
$year= $calendar->getYear(); // 1404 


$monthName=$calendar->getMonthName(); // تیر


$oneDayAfter= $calendar->addDay(); // return PersianCalendar object (1404-04-21)
$towDaysAfter=$calendar->addDays(2); // return PersianCalendar object (1404-04-22)

$diffInDays= $calendar->diffInDays(PersianCelendar::fromDate('1404-04-23')); // 3

$calendarString= $calendar->format('Y-m-d H:i:s') // "1404-04-20 23:30:30"

$carbonObject=$calendar->toCarbon(); // return Carbon object (2025-07-11)

// Coneverting calendars to others

$gregorianCalendar=$calendar->to(new GregorianCalendar()) // return GregorianCalendar object
$date =  $gregorianCalendar->format(); // "2025-07-11"
$year= $gregorianCalendar->getYear(); // 2025 
...

$hijriCalendar= $calendar->to(new HijriCalendar()); // return HijriCalendarobject
$date =  $hijriCalendar->format(); // "1447-01-15"
...


$isLeapYear=$calendar->isLeapYear() // false - سال 1404 کبیسه نیست


// Comparing two dates 

$gt=$calendar->gt(PersianCalendar::fromDate('1404-04-18')); // true
$lt=$calendar->lt(PersianCalendar::formDate('1404-04-15')); // false

// Set Timezone 
$calendar->timezone('Asia/Tehran'); 

// Get Timezone 
$timezone=$calendar->getTimezone(); 


// Set Date from timestamp 

$calendar->setTime(6598797121) // return PersianCalendar object
```

The Setter functions modify the $calendar object and do not return new object
