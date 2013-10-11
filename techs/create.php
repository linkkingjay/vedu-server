<?php
require_once('../config.inc');
require_once('../models.php');

// XXX
// really a **bad** idea to mix
// your program's logic and the view

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建一个分类</title>
</head>
<body>

<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') { ?>
    <form action="" method="POST">
        <input name="name" type="text" placeholder="名字" />
        <input name="description" type="text" placeholder="描述" />
        <input name="homepage" type="text" placeholder="主页" />
        <input value="提交" type="submit" />
    </form>
<?php } else if ($method === 'POST') {
    $result = create_tech($_POST['name'], $_POST['description'],
        $_POST['homepage']);

    header('Location: index.php');
} ?>

</body>
</html>
