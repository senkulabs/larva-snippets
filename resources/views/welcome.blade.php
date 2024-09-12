<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Larva Interactions</title>

        <!-- Styles -->
        <style>
           *, *::before, *::after {
            box-sizing: border-box;
           }
           
           html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
           }
        </style>
    </head>
    <body>
        <h1>Larva Interactions</h1>
        <p>Web interactions use Larva stack.</p>
        <p><em>Larva = Laravel + Livewire + AlpineJS + TailwindCSS</em></p>

        <h2>Contents:</h2>
        <ul>
            <li><a href="/button">Button</a></li>
            <li><a href="/select">Select</a></li>
            <li><a href="/alert">Alert</a></li>
            <li><a href="/nested-sortable">Nested Sortable</a></li>
            <li><a href="/form">Form</a></li>
            <li><a href="/upload-file">Upload File</a></li>
            <li><a href="/datatable">Datatable</a></li>
            <li><a href="/reset-password">Reset Password</a></li>
            <li><a href="#">Trix Editor</a></li>
        </ul>
    </body>
</html>
