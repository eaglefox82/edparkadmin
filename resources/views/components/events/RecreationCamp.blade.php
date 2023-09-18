<li class="nav-item {{ (request()->is('recreationcamp/'.$eventId.'*')) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-campground"></i>
        <p>
            {{ $eventName }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('recreationcamp.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.members.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/members*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Members</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.accommodation.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/accommodation*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Accommodation</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.teams.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/teams*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Teams</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.dietary.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/dietary*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Food/Dietary</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.medical.index', [ 'eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/medical*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Medical</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.accounting', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/accounting*')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Accounting</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recreationcamp.reports.overall', ['eventId' => $eventId]) }}"
               class="nav-link {{ (request()->is('recreationcamp/'.$eventId.'/report*')) ? 'active' : '' }}"
               target="_blank">
                <i class="far fa-circle nav-icon"></i>
                <p>Camp Report</p>
            </a>
        </li>
    </ul>
</li>
