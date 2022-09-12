<?php
require_once('Private/initialize.php');


if (is_post_request()) {
    if (isset($_POST['paste_title']) && isset($_POST['paste_content'])) {
        $title = $_POST['paste_title'];
        $text = $_POST['paste_content'];
        $userId = "DummyUser";
        if (isset($_SESSION['email']) && isset($_SESSION['logged']) && $_SESSION['logged'] == 'true') {
            $userId = $_SESSION['email'];
        }
        $new_id = create_text_paste($title, $text, $userId);
        redirect_to(url_for('pages/show.php?id=' . h($new_id)));
    } else {
        //Show some type of error
        echo "Please fill everything. <br />";
    }
}

$pastes = get_all_pastes();

include(PRIVATE_PATH . '/shared_header.php');
?>


<div class="grid-container">
    <div class="item1">
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
    </div>
    <div class="item2">
        <div id="content">
            <h2>Recent Pastes</h2>
            <br />
            <div class="show">
                <?php foreach ($pastes as $paste) { ?>
                    <div class="card" id=<?php echo 'card-button-' . $paste['id']; ?>>
                        <div class="container">
                            <h4><b><?php echo h($paste['title']); ?></b></h4>
                            <h4>ID: <?php echo h($paste['id']); ?></h4>
                            <p><?php echo h($paste['link']); ?></p>
                        </div>
                    </div>
                    <script>
                        var btn = document.getElementById(<?php echo '\'' . 'card-button-' . $paste['id'] . '\''; ?>);
                        btn.addEventListener('click', function() {
                            document.location.href = '<?php echo url_for('pages/show.php?id=' . h($paste['id'])); ?>';
                        });
                    </script>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php include(PRIVATE_PATH . '/shared_footer.php') ?>