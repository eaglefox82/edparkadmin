<?php

namespace App\View\Components\Events;

use App\Models\Event;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * The event to be displayed.
     *
     * @var Event
     */
    public $eventId;
    public $eventType;
    public $eventName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($eventName, $eventId, $eventType)
    {
        $this->eventName = $eventName;
        $this->eventId = $eventId;
        $this->eventType = $eventType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.events.'.$this->eventType);
    }
}
