<!DOCTYPE HTML>

<div class="navbar">
        <nav>
            <ul>
                <li><a <?php echo checkActiveClass("daily-fact.php"); ?>href="daily-fact.php">Daily Fact</a></li>
                <li><a <?php echo checkActiveClass("archive.php"); ?> href="archive.php">Archive</a></li>
                <li><a <?php echo checkActiveClass("about.php"); ?> href="about.php">About</a></li>
            </ul>    
        </nav>
    </div>

<?php
    function checkActiveClass($value) {
        $page = $_SERVER['REQUEST_URI'];
        $page = ltrim($page, "/");
        if($page == $value) {
            return "class='active'";
        }
    }
?>