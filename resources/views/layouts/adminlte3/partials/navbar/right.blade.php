@php
    $unread_notifications = Auth::user()->unreadNotifications
@endphp

<ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li id="navbar-notifications" class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span id="navbar-notifications-counter" class="badge badge-warning navbar-badge {{ $unread_notifications->count() > 0 ?: 'd-none' }}">{{ $unread_notifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ $unread_notifications->count() }} Notifications</span>
            <div class="dropdown-divider"></div>
            @forelse($unread_notifications->take(5) as $notification)
                <a href="{{ !empty($notification->data['redirect_url']) ? $notification->data['redirect_url'] : '#' }}" class="dropdown-item">
                    @if(!empty($notification->data['title']))
                        <p class="text-left font-weight-bold">{{ Illuminate\Support\Str::limit($notification->data['title'], 30) }}</p>
                    @endif
                    @if(!empty($notification->data['message']))
                        <p class="text-muted text-sm">{{ Illuminate\Support\Str::limit($notification->data['message'], 90) }}</p>
                    @endif
                    <p class="text-right text-muted text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
                <div class="dropdown-divider"></div>
            @empty
                <p class="text-center text-muted m-2">There are no new notifications.</p>
            @endforelse
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <a class="nav-link" href="javascript:;" onclick="parentNode.submit();" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </form>
    </li>
</ul>
