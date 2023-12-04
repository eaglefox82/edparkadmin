<li class="nav-item {{ (request()->is('cadet_comp/'.$eventId.'*')) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ $eventName }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('cadet_comp.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('trainingcamp/'.$eventId.'')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('cadet_comp/'.$eventId.'/admin*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('cadet_comp/'.$eventId.'/admin*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Administration
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('cadet_comp.uniforminspection.index', ['eventId' => $eventId]) }}"
                       class="nav-link {{ (request()->is('cadet_comp/'.$eventId.'/admin/inspectionfields*')) ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Inspections Fields</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
