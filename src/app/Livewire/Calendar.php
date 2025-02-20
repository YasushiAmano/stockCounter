<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Http\Services\EventServices;

class Calendar extends Component
{
    public $currentDate;
    public $day;
    public $checkDay; // 日付判定用
    public $dayOfWeek; // 曜日
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
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
            array_push($this->currentWeek, [ // 連想配列に変更
                'day' => $this->day, // カレンダー表示用 (○月△日)
                'checkDay' => $this->checkDay, // 判定用 (○○○○-△△-□□)
                'dayOfWeek' => $this->dayOfWeek // 曜日
            ]);
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
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;
            array_push($this->currentWeek, [ // 連想配列に変更
                'day' => $this->day, // カレンダー表示用 (○月△日)
                'checkDay' => $this->checkDay, // 判定用 (○○○○-△△-□□)
                'dayOfWeek' => $this->dayOfWeek // 曜日
            ]);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
