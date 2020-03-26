<nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #9153A1;">
  <a class="navbar-brand" href="#">
     <img src="{{asset('img/logo@4x.png')}}" width="94px" style="padding-top: 12%; ">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample05">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="">Articles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_URL.'users'; ?>">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_URL.'sender'; ?>">Senders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_URL.'credits'; ?>">Credits</a>
      </li>
    </ul>
  </div>
</nav>

