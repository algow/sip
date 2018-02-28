@if (session()->has('flash_notification.message'))
    <p class="text-{{ session()->get('flash_notification.level') }}" style="text-align:center; font-size:15px">
        {!! session()->get('flash_notification.message') !!}
    </p>
@endif