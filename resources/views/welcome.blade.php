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

           .container {
            width: 100%;
           }

           @media screen and (min-width: 1024px) {
                .container {
                    max-width: 1024px;
                }
           }
        </style>
    </head>
    <body>
        <div class="container" style="margin: 0 auto; padding: 1rem;">
            <h1>Larva Interactions</h1>
            <p>Web interactions use Larva stack.</p>
            <p><em>Larva = Laravel + Livewire + AlpineJS + TailwindCSS</em></p>
            <p><strong>Wait! ✋</strong></p>
            <p><em>There's a term called TALL (TailwindCSS + Alpine + Laravel + Livewire) stack! You don't know it!?</em></p>
            <p>I know it! But, I want to create alternative term. Larva is cool and fun! I bet you have heard "Larva" before. :)</p>
            <details>
                <summary>Enough! Show to me what do you mean!</summary>

                <img src="/larva-cartoon.jpg" alt="Larva cartoon">
            </details>
            <h2>Contents</h2>
            <ul>
                <li><a href="/form">Form</a></li>
                <li><a href="/third-party">Third Party</a></li>
                <li><a href="/datatable">Datatable</a></li>
                <li><a href="/job-batching">Job Batching</a></li>
            </ul>
        </div>
    </body>
</html>
