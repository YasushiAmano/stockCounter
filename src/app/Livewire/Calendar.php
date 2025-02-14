<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Http\Services\EventServices;
class Calendar extends Component
{
    public $currentDate;
    public $day;
    public $currentWeek;
    public $sevenDaysLater;
    public $events;

    public function mount()
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        $this->events = EventServices::getWeekEvents($this->currentDate->format('Y-m-d'), $this->sevenDaysLater->format('Y-m-d'));

        for ($i = 0; $i < 7; $i++) {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            array_push($this->currentWeek, $this->day);
        }
        $this->events = EventServices::getWeekEvents($this->currentDate, $this->sevenDaysLater);
    }

    public function getDate($date)
    {
        $this->currentDate = $date;
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);
        $this->currentWeek = [];
        $this->events = EventServices::getWeekEvents($this->currentDate, $this->sevenDaysLater->format('Y-m-d'));

        for ($i = 0; $i < 7; $i++) {
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            array_push($this->currentWeek, $this->day);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
