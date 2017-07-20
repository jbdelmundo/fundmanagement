<html>
    <body>
        <h2>{{$user['message']}}</h2>
        @if($user['request'])
		<h4>
			@foreach($user['request'] as  $item => $value)
				{{$item}}: {{$value}}<br>
			@endforeach
		</h4>
		@endif
    </body>
</html>