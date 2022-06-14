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

    <?php
      $categories_query = mysqli_query($connection, "SELECT * FROM `categories`");
      $categories = array();
      while ( $cat = mysqli_fetch_assoc($categories_query)) {
        $categories[] = $cat;
      }

      $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE id = " . (int) $_GET['id']);
      $art = mysqli_fetch_assoc($article);
    ?>

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
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a><?php echo $art['views']; ?> просмотров</a>
              <h3><?php echo $art['title']; ?></h3>
              <div class="block__content">
                <img src="/media/images/<?php echo $art['image']; ?>">

                <div class="full-text">
                  <?php echo $art['text']; ?>
                </div>
              </div>
            </div>

            <div class="block">
              <a href="#comment-add-form">Добавить свой</a>
              <h3>Комментарии к статье</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                  <article class="article">
                    <div class="article__image" style="background-image: url(/media/images/post-image.jpg);"></div>
                    <div class="article__info">
                      <a href="#">Сэм Фишер</a>
                      <div class="article__info__meta">
                        <small>10 минут назад</small>
                      </div>
                      <div class="article__info__preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna ...</div>
                    </div>
                  </article>

                  <article class="article">
                    <div class="article__image" style="background-image: url(/media/images/post-image.jpg);"></div>
                    <div class="article__info">
                      <a href="#">Сэм Фишер</a>
                      <div class="article__info__meta">
                        <small>10 минут назад</small>
                      </div>
                      <div class="article__info__preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna ...</div>
                    </div>
                  </article>

                  <article class="article">
                    <div class="article__image" style="background-image: url(/media/images/post-image.jpg);"></div>
                    <div class="article__info">
                      <a href="#">Сэм Фишер</a>
                      <div class="article__info__meta">
                        <small>10 минут назад</small>
                      </div>
                      <div class="article__info__preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna ...</div>
                    </div>
                  </article>

                </div>
              </div>
            </div>

            <div class="block" id="comment-add-form">
              <h3>Добавить комментарий</h3>
              <div class="block__content">
                <form class="form">
                  <div class="form__group">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form__control" required="" name="name" placeholder="Имя">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form__control" required="" name="nickname" placeholder="Никнейм">
                      </div>
                    </div>
                  </div>
                  <div class="form__group">
                    <textarea name="text" required="" class="form__control" placeholder="Текст комментария ..."></textarea>
                  </div>
                  <div class="form__group">
                    <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
                  </div>
                </form>
              </div>
            </div>
          </section>
          <section class="content__right col-md-4">
            <div class="block">
              <h3>Топ читаемых статей</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                  <?php
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` LIMIT 10");
                  ?>

                  <?php
                    while ( $pic = mysqli_fetch_assoc($articles)) {?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/media/images/<?php echo $pic['image'] ?>);"></div>
                        <div class="article__info">
                          <a href="/articles.php?categorie=<?php echo $pic['id']; ?>"><?php echo $pic['title']; ?></a>
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

  </div>

</body>
</html>
