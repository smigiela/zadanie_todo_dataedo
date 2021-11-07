@if ($errors->any())
    <div class="alert-box danger-alert">
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(Session::has('message'))
<div class="alert-box success-alert">
    <div class="alert">
        <p>
            {{ Session::get('message') }}
        </p>
    </div>
</div>
@endif
