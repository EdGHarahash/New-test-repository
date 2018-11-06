<html>
  <head>
    <meta charset="utf-8">
    <title>MVC PHP</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>

    <!-- Top Menu -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
            <?php
            if (!empty($user)) {
              ?>
              <li><a href = "/profile/show">My Profile</a></li>
              <li><a href = "/security/logout">Exit</a></li>
              <?php
            }
            else {
              ?>
              <li><a href = "/security/auth">Sign in</a></li>
              <li><a href = "/security/reg">Register</a></li>
              <?php
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Centered Pane -->
    <div class="main-pane">