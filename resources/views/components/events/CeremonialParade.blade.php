<li class="nav-item {{ (request()->is('ceremonialparade/'.$eventId.'*')) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-flag"></i>
        <p>
            {{ $eventName }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ceremonialparade.index', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('ceremonialparade/'.$eventId)) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ceremonialparade.squadron', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('ceremonialparade/'.$eventId.'/squadron*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Squadron Check-In</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ceremonialparade.wing', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('ceremonialparade/'.$eventId.'/wing*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Wing Check-In</p>
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a href="#" class="nav-link">--}}
{{--                <i class="far fa-circle nav-icon"></i>--}}
{{--                <p>Trophy Master List</p>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</li>
