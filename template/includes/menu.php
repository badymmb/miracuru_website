<?php

  $characterName = "";

  if (!empty($_GET["name"]))
    $characterName = $_GET["name"];

?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark mt-2">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <img class="menu-image" src="public/images/news.png" />
            Noticias <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ranking.php?type=level">
            <img class="menu-image" src="public/images/ranking.png" />
            Ranking
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="regras.php">
            <img class="menu-image" src="public/images/rules.png" />
            Regras
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="loja.php">
            <img class="menu-image" src="public/images/shopping.png" />
            Loja
        </a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="character.php" method="GET">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputSearchPerson"><i class="fas fa-search"></i></span>
            </div>
            <input 
                type="text" 
                class="form-control" 
                id="name"
                name="name"
                placeholder="Busque um character" 
                aria-label="Busque um character" 
                aria-describedby="basic-addon1"
                value="<?php echo $characterName; ?>" />
        </div>
    </form>
  </div>
</nav>