<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @inertiaHead
  </head>
  <body class=" dark:bg-gray-900 dark:text-gray-200 bg-white text-gray-900">
    @inertia
    @routes
  </body>
</html>
