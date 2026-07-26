<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex,nofollow" />
        <title>{{ $title }}</title>
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: grid;
                place-items: center;
                padding: 2rem;
                box-sizing: border-box;
                color: #1e271f;
                background: #f5f0e7;
                font-family: system-ui, sans-serif;
            }
            main {
                max-width: 42rem;
                padding: 3rem;
                text-align: center;
                border-radius: 1.5rem;
                background: #fbf8f1;
                box-shadow: 0 18px 55px rgb(47 57 39 / 10%);
            }
            strong {
                display: block;
                color: #24462d;
                font-family: Georgia, serif;
                font-size: clamp(3rem, 10vw, 6rem);
            }
            h1 {
                color: #24462d;
            }
            p {
                line-height: 1.7;
            }
            a {
                display: inline-block;
                margin-top: 1rem;
                padding: 0.8rem 1.25rem;
                color: white;
                background: #24462d;
                border-radius: 999px;
            }
        </style>
    </head>
    <body>
        <main>
            <strong>{{ $code }}</strong>
            <h1>{{ $title }}</h1>
            <p>{{ $message }}</p>
            <a href="/">Return home</a>
        </main>
    </body>
</html>
