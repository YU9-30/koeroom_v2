<nav class="navbar is-light" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
      <h1 class="title is-text-color-light">KoeRoom</h1>
    </a>
    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbar-normal">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div class="navbar-menu "  id="navbar-normal">
    <div class="navbar-end">
      <div class="navbar-item">
        <?php if($_SESSION['auth']){ ?>
          <div class="user-info my-2 mx-2">
            <p><?php echo $_SESSION['username']; ?> さん</p>
          </div>
          <div class="buttons">
            <form action="" method="post">
            <button class="button is-danger" name="logout">
              <strong>ログアウト</strong>
            </button>
            </form>
          </div>
          
        <?php } else { ?>
          <div class="buttons">
            <a href="/login" class="button is-primary">
              <p class="strong">ログイン</p>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</nav>