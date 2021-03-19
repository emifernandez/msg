<?php

namespace App\Formatters;

use Carbon\Carbon;

class DateFormatter
{
    /**
     * Carbon $date
     */
    private $date;

    /**
     * Inject Date from Entity
     */
    public function __construct($date)
    {
        $this->date = Carbon::make($date);
    }

    /**
     * Format Date for Form Use
     */
    public function forForm()
    {
        return $this->date == null ? '' : $this->date->format('d-m-Y');
    }

    public function forString()
    {
        return $this->date == null ? '' : $this->date->format('Y-m-');
    }

    public function forFormDateHour()
    {
        return $this->date == null ? '' : $this->date->format('d-m-Y H:i:s');
    }

    public function forFormHour()
    {
        return $this->date == null ? '' : $this->date->format('H:i');
    }

    public function getWeekDay()
    {
        return $this->date->dayOfWeek + 1;
    }

    /**
     * Format date for Profile
     */
    public function forHumans()
    {
        return $this->date->diffForHumans();
    }

    public function subDays($days)
    {
        return $this->date->subDays($days);
    }

    public function lt($date)
    {
        return $this->date->lt($date);
    }
}
