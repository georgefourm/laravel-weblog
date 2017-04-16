<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A simple utility to view your application's logs online">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>WebLog</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-light_green.min.css" />
    <style>
      .full-width {
          width: 100%;
      }
      .link {
        color: #004009
      }
      .text-container{
        padding:10px;
        overflow:auto;
        height:50em;
      }
    </style>
  </head>
  <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
          <h3>WebLog</h3>
        </div>
      </header>
      <main class="mdl-layout__content">
        <div class="mdl-layout__tab-panel is-active" id="index">
          <section class="section--center mdl-grid">
              @yield('content')
          </section>
        </div>
      </main>
    </div>
  <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrender/0.9.84/jsrender.min.js" 
    integrity="sha256-QTUWKa+JGRD76a4eJlFh8vKZXYQeSXdyFZaFlvo225A=" 
    crossorigin="anonymous"></script>
    @stack('scripts')
  </body>
</html>
