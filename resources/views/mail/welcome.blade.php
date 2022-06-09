<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="my-6 font-mono min-h-screen antialiased bg-slate-900">
  <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
  
  <div class="mt-6 mx-6 md:mx-auto max-w-4xl bg-slate-200 rounded-lg p-4 space-y-3">
    <h1 class="text-xl mb-4 font-bold">Olá, {{ $user->name }}!</h1>
    <p>
      Obrigado por registrar-se em nosso sistema.
    </p>

    <p>
      Att,<br>
      {{ env('APP_NAME', "Laravel Actions") }}
    </p>
  </div>
</body>

</html>