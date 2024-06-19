<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile-Friendly Site</title>
    @vite(['resources/js/app.js'])
    <style>
        html,body {
            background: #333;
            color: #eee;
            font-size: 11px;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body id="app">
<main>
    <snow-white></snow-white>
</main>
</body>
</html>
