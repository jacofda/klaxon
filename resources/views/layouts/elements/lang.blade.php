<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-language"></i>
    </a>

    <div class="dropdown-menu">
        @if(app()->getLocale() == 'en')
            <a href="#" class="dropdown-item"  onclick="event.preventDefault();document.getElementById('lang-form').submit();">ITA</a>
        @else
            <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('lang-form').submit();">ENG</a>
        @endif


    </div>

</li>

    <form id="lang-form" action="{{ url('switch-locale') }}" method="POST" style="display: none;">
        @csrf
    </form>
