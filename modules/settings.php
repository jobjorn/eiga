<?php


include("core.php");

$active['settings'] = 'class="active"';


$page_title = "Settings";
include("header.php");

?>
<div class="container">
    <div class="col-md-12">
        <h1>Settings</h1>

        <form action="<?php echo $root_uri; ?>do_settings" method="post">
            <p><input type="submit" value="Submit"></p>
        </form>
    </div>
</div>



<?php

include("footer.php");
