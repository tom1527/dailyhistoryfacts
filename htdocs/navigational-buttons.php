<!DOCTYPE HTML>
<?php
        echo '
        "<div class="navbar">
        <nav>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a class="active" href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>';


    /* While abstracting out the navbar with "include" reduces complexity on each page and allows for uniformed alterations,
    it makes the "active" class in CSS redundant. As such, this requires more work before implementation. */
?>
