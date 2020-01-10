<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php">* HELLO
        <?php
        if (isset($_COOKIE['gateauChoco'])) {
            echo $_COOKIE['gateauChoco'];
        }
        ?>
        *</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
        <div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deconnexion.php">Deconnection</a>
                </li>
                <li class="nav-item">
                    <i class="fa fa-forumbee" style="color: yellow;" aria-hidden="true"></i>
                </li>


        </div>
        <div class="navbar-nav">
            <li class="nav-item">
                <!-- pour cacher "ecrire un article" quand on est pas connecté-->
                <?php
                if (isset($_COOKIE['gateauChoco'])) {
                ?>
                    <a class="nav-link text-right" href="article.php">Ecrire un article</a>
                <?php
                }
                ?>
            </li>
        </div>
        </ul>
    </div>
</nav>