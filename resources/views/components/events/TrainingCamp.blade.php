<li class="nav-item {{ (request()->is('trainingcamp/'.$eventId.'*')) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ $eventName }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('trainingcamp.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.members.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/members*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Members</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.band.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/band*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Band Training</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.day_visitors.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/day_visitors*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Day Visitors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.flights.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/flights*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Flights</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.accommodation.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/accommodation*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Accommodation</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.dietary.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/dietary*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Food/Dietary</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.medical.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/medical*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Medical</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.schedule.index', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/schedule*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Meal Schedules</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('trainingcamp.uniforminspection.view', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/uniforminspection*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Uniform Inspections</p>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('trainingcamp/'.$eventId.'/admin*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/admin*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Administration
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
{{--                <li class="nav-item">--}}
{{--                    <a href="#" class="nav-link">--}}
{{--                        <i class="far fa-dot-circle nav-icon"></i>--}}
{{--                        <p>Lessons</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a href="{{ route('trainingcamp.uniforminspection.index', ['eventId' => $eventId]) }}"
                       class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/admin/inspectionfields*')) ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Inspections Fields</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('trainingcamp.accounting', ['eventId' => $eventId]) }}"
                       class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/admin/accounting*')) ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Accounting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('trainingcamp.reports.overall', ['eventId' => $eventId]) }}"
                       class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'/admin/report*')) ? 'active' : '' }}"
                       target="_blank">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Camp Reports</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
