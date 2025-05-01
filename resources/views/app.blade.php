<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link crossorigin="use-credentials" rel="manifest" href="/site.webmanifest">
  <link rel='shortcut icon' :href="'/favicon.ico'" type='image/x-icon'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @inertiaHead
  </head>
  <body class=" dark:bg-gray-900 dark:text-gray-200 bg-white text-gray-900">
    @inertia
    @routes
  </body>
</html>
