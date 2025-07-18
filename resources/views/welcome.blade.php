<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Larva Snippets</title>

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
            <h1>Larva Snippets</h1>
            <p>Reuseable pieces of Larva stack.</p>
            <p><em>Larva = Laravel + Livewire + Tailwind + Alpine</em></p>
            <blockquote class="bg-gray-100"><em>Hold on! ✋</em></blockquote>
            <blockquote><em>"There's a term called TALL (Tailwind + Alpine + Laravel + Livewire) stack! You don't know it!?"</em></blockquote>
            <blockquote>I know it! But, I want to create alternative term. Larva is cool and fun! I bet you have heard "Larva" before. :)</blockquote>
            <blockquote><em>"Hmm, where is it?"</em></blockquote>
            <blockquote>
                <details>
                    <summary>Here we go! 👀</summary>

                    <img src="/larva-cartoon.jpg" alt="Larva cartoon">
                </details>
            </blockquote>
            <h2>Contents</h2>
            <ul>
                <li><a href="/form">Form</a></li>
                <li><a href="/reset-password">Reset Password</a></li>
                <li><a href="/alert">Alert</a></li>
                <li><a href="/select">Select</a></li>
                <li><a href="/third-party">Third Party</a></li>
                <li><a href="/datatable">Datatable</a></li>
                <li><a href="/job-batching">Job Batching</a></li>
            </ul>
        </div>
    </body>
</html>
