<!DOCTYPE html>
<?php
  require "includes/config.php"
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title']; ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">

    <header id="header">
      <div class="header__top">
        <div class="container">
          <div class="header__top__logo">
            <h1><?php echo $config['title']; ?></h1>
          </div>
          <nav class="header__top__menu">
            <ul>
              <li><a href="/">Главная</a></li>
              <li><a href="/pages/aboutme.php">Обо мне</a></li>
              <li><a href="#">Я Вконтакте</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <?php
        $categories = mysqli_query($connection, "SELECT * FROM `categories`");
      ?>
      <div class="header__bottom">
        <div class="container">
          <nav>
            <ul>
              <?php
                while ( $category = mysqli_fetch_assoc($categories)){?>
                  <li><a href="/articles.php?categorie=<?php echo $category['id']; ?>"><?php echo $category['title']; ?></a> </li>
                <?php
                }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <div id="content">
      <div class="container">
        <?php if ((int) $_GET['categorie'] == 0){
          $categories = mysqli_query($connection, "SELECT * FROM `categories`");
          while ( $category = mysqli_fetch_assoc($categories)){?>
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3><?php echo $category['title']; ?></h3>
              <div class="block__content">
                <div class="articles articles__vertical">
              <br>
                <?php
                  $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `category_id` = " . $category['id']);
                ?>
                <?php
                  while ( $pic = mysqli_fetch_assoc($articles)) {?>
                    <article class="article">
                      <div class="article__image" style="background-image: url(/media/images/<?php echo $pic['image'] ?>);"></div>
                      <div class="article__info">
                        <a href="/article.php?id=<?php echo $pic['id']; ?>"><?php echo $pic['title']; ?></a>
                        <div class="article__info__meta">
                          <small>Категория: <a href="/articles.php?categorie=<?php echo $category['id']; ?>"><?php echo $category['title']; ?></a></small>
                        </div>
                        <div class="article__info__preview"><?php echo mb_substr($pic['text'], 0, 50, 'utf-8'); ?></div>
                      </div>
                    </article>
                  <?php
                  }
                ?>
                </div>
              </div>
            </div>
          </section>
        </div>
      <?php }} else{
          $categories = mysqli_query($connection, "SELECT * FROM `categories` WHERE `id` = " . $_GET['categorie']);
          $category = mysqli_fetch_assoc($categories);?>
          <h3><?php echo $category['title']; ?></h3>
          <br>
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3><?php echo $category['title']; ?></h3>
              <div class="block__content">
                <div class="articles articles__vertical">
              <br>
                <?php
                  $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `category_id` = " . $_GET['categorie']);
                ?>
                <?php
                  while ( $pic = mysqli_fetch_assoc($articles)) {?>
                    <article class="article">
                      <div class="article__image" style="background-image: url(/media/images/<?php echo $pic['image'] ?>);"></div>
                      <div class="article__info">
                        <a href="/article.php?id=<?php echo $pic['id']; ?>"><?php echo $pic['title']; ?></a>
                        <div class="article__info__meta">
                          <small>Категория: <a href="/articles.php?categorie=<?php echo $category['id']; ?>"><?php echo $category['title']; ?></a></small>
                        </div>
                        <div class="article__info__preview"><?php echo mb_substr($pic['text'], 0, 50, 'utf-8'); ?></div>
                      </div>
                    </article>
                  <?php
                  }
                ?>
                </div>
              </div>
            </div>
          </section>
        </div>
      <?php }?>
          <section class="content__right col-md-4">
            <div class="block">
              <h3>Топ читаемых статей</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                  <?php
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `view` LIMIT 10");
                  ?>

                  <?php
                    while ( $pic = mysqli_fetch_assoc($articles)) {?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/media/images/<?php echo $pic['image'] ?>);"></div>
                        <div class="article__info">
                          <a href="/article.php?id=<?php echo $pic['id']; ?>"><?php echo $pic['title']; ?></a>
                          <div class="article__info__meta">
                            <?php
                            $art_cat = false;
                            foreach ($categories as $cat) {
                              if($cat['id'] == $pic['category_id']){
                                $art_cat = $cat;
                                break;
                              }
                            }?>
                            <small>Категория: <a href="/articles.php?categorie=<?php echo $art_cat['id']; ?>"><?php echo $art_cat['title']; ?></a></small>
                          </div>
                          <div class="article__info__preview"><?php echo mb_substr($pic['text'], 0, 50, 'utf-8'); ?></div>
                        </div>
                      </article>
                    <?php
                    }
                  ?>

                </div>
              </div>
            </div>

            <div class="block">
              <h3>Комментарии</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                  <?php
                    $articles = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `id` DESC LIMIT 5");
                  ?>

                  <?php
                    while ( $pic = mysqli_fetch_assoc($articles)) {?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/media/images/post-image.jpg);"></div>
                        <div class="article__info">
                          <a href="#"><?php echo $pic['author']; ?></a>
                          <div class="article__info__meta">
                            <?php
                              $artic = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . $pic['articles_id']);
                              $ar = mysqli_fetch_assoc($artic)
                            ?>
                            <small><a href="#"><?php echo $ar['title']; ?></a></small>
                          </div>
                          <div class="article__info__preview"><?php echo mb_substr($pic['text'], 0, 50, 'utf-8'); ?></div>
                        </div>
                      </article>
                    <?php
                    }
                  ?>

                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

    <footer id="footer">
      <div class="container">
        <div class="footer__logo">
          <h1><?php echo $config['title']; ?></h1>
        </div>
        <nav class="footer__menu">
          <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/pages/aboutme.php">Обо мне</a></li>
            <li><a href="#">Я Вконтакте</a></li>
          </ul>
        </nav>
      </div>
    </footer>

</body>
</html>
