<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Daylite</title>

        <style>
          body {
            background: #eee;
          }
          #app {
            font-family: "Avenir", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-align: center;
            color: #2c3e50;
            margin-top: 60px;
          }
          .add-city-form {
            margin: 20px 0;
          }
          button.btn {
            background: #434792;
            border: none;
            padding: 0.2em 0.4em;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.05s;
          }
          button.btn:hover {
            background: #5059f4;
          }
          .content {
            position: relative;
          }
          .loading, .error {
            position: absolute;
            left: 0;
            right: 0;
            top: -6px;
            margin: auto;
            padding: 0.4em;
            background: #b7f7bd;
            width: 100%;
            max-width: 500px;
            border-radius: 4px;
          }
          .error {
            background: #f79467;
          }
          .daylite-description {
            margin: 10px 0;
          }
          .daylite-description__color {
            display: inline-block;
            transform: translateY(2px);
            width: 1em;
            height: 1em;
            border-radius: 50%;
            background: pink;
          }
          ul.nav > li {
            display: inline;
            padding-left: 10px;
          }
          ul.nav > li::before {
            content: "\2630";
            padding-right: 5px;
          }
        </style>

    </head>
    <body>
        <div id="app">
            <daylites></daylites>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
