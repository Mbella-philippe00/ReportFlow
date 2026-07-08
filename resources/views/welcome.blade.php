<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#2563eb">
        <meta name="color-scheme" content="light dark">
        <meta name="description" content="Enterprise weekly reporting workflow platform">
        <link rel="manifest" href="/manifest.webmanifest">

        <title>{{ config('app.name', 'ReportFlow') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/main.tsx'])
    </head>
    <body class="bg-background font-sans antialiased">
        <div id="app"></div>
    </body>
</html>

