<?php
require_once('../Private/initialize.php');

if(!isset($_SESSION['logged']) || $_SESSION['logged'] == 'false') {
    redirect_to(url_for('pages/authenticate.php'));
}


$userId = $_SESSION['email'];
$pastes = get_pastes_by_userId($userId);
include(PRIVATE_PATH . '/shared_header.php');
?>

<div id="content">
    <div class="show">
        <?php foreach ($pastes as $paste) { ?>
            <div class="card" id=<?php echo 'card-button-' . $paste['id']; ?>>
                <div class="container">
                    <h4><b><?php echo h($paste['title']); ?></b></h4>
                    <h4>ID: <?php echo h($paste['id']); ?></h4>
                    <p><?php echo h($paste['content']); ?></p>
                </div>
            </div>
            <script>
                var btn = document.getElementById(<?php echo '\'' . 'card-button-' . $paste['id'] .'\''; ?>);
                btn.addEventListener('click', function() {
                    document.location.href = '<?php echo url_for('pages/show.php?id=' . h($paste['id'])); ?>';
                });
            </script>
        <?php } ?>
    </div>
</div>

<?php
include(PRIVATE_PATH . '/shared_footer.php');
