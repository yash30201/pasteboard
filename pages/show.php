<?php
require_once('../Private/initialize.php');

if (!isset($_GET['id'])) {
    redirect_to('index.php');
}

// if(!not_found_in_db){
//     redirect_to('index.php');
// }

include(PRIVATE_PATH . '/shared_header.php');

$id = $_GET['id'];
$paste = get_paste_by_id($id);
$title = $paste['title'];
$text = $paste['link'];
?>

<div id="content">
    <div class="show">
        <dl>
            <dt>ID: </dt>
            <dd><?php echo h($id) ?></dd>
        </dl>
        <dl>
            <dt>Title: </dt>
            <dd><?php echo h($title) ?></dd>
        </dl>
        <dl>
            <dt>Text: </dt>
            <dd><?php echo h($text) ?></dd>
        </dl>
    </div>
</div>

<?php
include(PRIVATE_PATH . '/shared_footer.php');
