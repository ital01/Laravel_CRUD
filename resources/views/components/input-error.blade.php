@props(['messages'])

<ul>
    @foreach ((array) $messages as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>