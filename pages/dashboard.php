<?php
require_once('../Private/initialize.php');

// if(!not_found_in_db){
//     redirect_to('index.php');
// }

// for now this function will show all the pastes of all users instead of just a single user

include(PRIVATE_PATH . '/shared_header.php');

$pastes = get_all_pastes();
?>

<div id="content">
    <div class="show">
        <?php foreach($pastes as $paste) {?>
            <div class="card">
                <div class="container">
                    <h4><b><?php echo h($paste['title']);?></b></h4>
                    <h4>ID: <?php echo h($paste['id']);?></h4>
                    <p><?php echo h($paste['link']);?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
include(PRIVATE_PATH . '/shared_footer.php');
