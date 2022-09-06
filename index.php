<?php
require_once('Private/initialize.php');
include(PRIVATE_PATH . '/shared_header.php');


if(is_post_request()) {
    if(isset($_POST['paste_title']) && isset($_POST['paste_content'])) {
        $title = $_POST['paste_title'];
        $text = $_POST['paste_content'];
        $userId = "DummyUser";

        $new_id = create_text_paste($title, $text, $userId);
        redirect_to(url_for('pages/show.php?id=' . h($new_id)));
    } else{
        //Show some type of error
        echo "Please fill everything. <br />";
    }
    
}

?>

<div id="content">
    <h1>Create New Paste</h1>

    <form action="" method="post">
        <dl>
            <dt>Paste Title</dt>
            <dd><input type="text" name="paste_title" value=""></dd>
        </dl>
        <dl>
            <dt>Content</dt>
            <dd>
                <textarea name="paste_content" cols="30" rows="10" value=""></textarea>
            </dd>
        </dl>
        <div id="operations">
            <input type="submit" value="Create Paste" />
        </div>
    </form>
</div>


<?php include(PRIVATE_PATH . '/shared_footer.php')?>