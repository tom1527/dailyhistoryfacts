<!DOCTYPE HTML>

    <div class="navbar">
        <nav>
            <ul>
                <li><a <?php echo checkActiveClass("daily-fact"); ?>href="daily-fact.php">Daily Fact</a></li>
                <li><a <?php echo checkActiveClass("archive"); ?> href="archive.php">Archive</a></li>
                <li><a <?php echo checkActiveClass("about"); ?> href="about.php">About</a></li>
            </ul>    
        </nav>
    </div>

<?php
    function checkActiveClass($value) {
        $page = $_SERVER['REQUEST_URI'];
        $page = ltrim($page, "/");
        $page = substr($page, 0 , strpos($page, "."));

        if($page == $value) {
            return "class='active'";
        }
    }
?>
