<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><?php echo lang('HOME_ADMIN'); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li class="active"><a href="categories.php"><?php echo lang('CATEGORIES'); ?></a></li>
        <li class="active"><a href="items.php"><?php echo lang('ITEMS'); ?></a></li>
        <li class="active"><a href="member.php?do=manage"><?php echo lang('MEMBERS'); ?></a></li>
        <li class="active"><a href="comments.php?do=manage"><?php echo lang('COMMENT'); ?></a></li>
       
      </ul>
     
     
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">thomas <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="../index.php">Visite shop</a></li>
            <li><a href="member.php?do=edit&userid=<?php echo $_SESSION['ID']; ?>">Edit profile</a></li>
            <li><a href="#">Setting</a></li>
            <li><a href="logout.php">Logout</a></li>
        
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>