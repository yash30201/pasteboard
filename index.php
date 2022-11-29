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

$pastes = get_recent_pastes();

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
                    <input type="submit" class="slide-hover-left-1" value="Create Paste" />
                </div>
            </form>
        </div>
    </div>

    <div class="item2">
        <div class="content-dash">
            <div class="heading">
                <h1 class="heading__title">Recent Pastes</h1>
            </div>
            <div class="cards">
                <?php $index = 1 ?>
                <?php foreach ($pastes as $paste) {?>
                    <div class="<?php echo 'card card-' . $index++ ;?>" id=<?php echo 'card-button-' . $paste['id']; ?>>
                        <h2 class="card__title"><?php echo h($paste['title']); ?></h2>
                        <p class="card__apply">
                            <div class="card__link"><i class="fas fa-arrow-right"></i></div>
                        </p>
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
