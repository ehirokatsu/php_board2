<head>
  <title>Laravel Sample</title>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('/js/javascript.js') }}"></script>
@yield('content')