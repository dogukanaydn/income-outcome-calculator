<?php

require_once 'config.php';

$query = "SELECT * FROM list ";
$listResult = '';
if (!empty($connection)) {
    $listResult = $connection->query($query);
    if (empty($listResult)) die("Income  list  failed");
}

$lists = array();
while ($row = $listResult->fetch_array(MYSQLI_ASSOC)) {
    $lists[] =  $row;
}

$totalIncome = 0;
$totalOutcome = 0;
$profit = 0;

foreach ($lists as $list) {
    if ($list['inc_out'] == 'income') {
        $totalIncome = $totalIncome + $list['money'];
    } else {
        $totalOutcome = $totalOutcome + $list['money'];
    }
}

if ($totalIncome > $totalOutcome) {
    $profit = $totalIncome - $totalOutcome;
} elseif ($totalOutcome > $totalIncome) {
    $profit = $totalIncome - $totalOutcome;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income-Outcome Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
        #message {
        }
    </style>
</head>
<body>
<?php  require_once 'actions.php'; ?>
<?php if (isset($_SESSION['message'])): ?>
    <div id="message" class="success" >
        <p  id="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    </div>
<?php endif; ?>
<script>
    var message = document.getElementById('message');
    message.onclick = setTimeout(function() {
        message.style.display = 'none';
    }, 5000);
</script>


<div class="grid">

    <div class="card grid-income">

        <p class="income-head">INCOME</p>
        <div>
            <form action="actions.php" method="post">
                <div class="input-txt">

                    <label for="name">Name: <br></label>
                    <input type="text" id="name" name="name" autocomplete="off" required> <br>
                </div>
                <div class="input-txt">
                    <label for="how-much">How much: <br></label>
                    <input type="number" step="0.01" id="how-much" name="how-much" autocomplete="off" required> <br>
                </div>
                <input type="hidden" name="stat" value="income">
                <input type="submit" value="ADD"  class="btn-add">
            </form>

        </div>

    </div>
    <div class="card grid-outcome">

        <p class="income-head">OUTCOME</p>
        <div>
            <form action="actions.php" method="post">
                <div class="input-txt">

                    <label for="name">Name: <br></label>
                    <input type="text" id="name" name="name" autocomplete="off" required > <br>
                </div>
                <div class="input-txt">
                    <label for="how-much">How much: <br></label>
                    <input type="number" step="0.01" id="how-much" name="how-much" autocomplete="off" required> <br>
                </div>
                <input type="hidden" name="stat" value="outcome">
                <input type="submit" name="submitted"  value="ADD"  class="btn-add">
            </form>

        </div>

    </div>
    <div class="grid-main">
        <div class="income-list-div">
            <p class="list">INCOME LIST</p>
            <div class="list-frame">
                <div class="table">
                    <table>
                        <tr>
                            <td class="table-header">Name</td>
                            <td class="table-header">Money</td>
                            <td class="table-header">Status</td>
                        </tr>
                        <?php foreach ($lists as  $list) { if ($list['inc_out'] == 'income') { ?>
                            <tr>
                                <td><?php echo $list['name']?></td>
                                <td><?php echo $list['money']?></td>

                                <td>
                                    <form action="actions.php" method="post">
                                        <input type="hidden" name="selected-name" value="<?php echo $list['name'] ?>">
                                        <span><input type="submit" name="edit" value="Edit"></span>
                                        <span><input type="submit" name="delete" value="Delete"></span>
                                    </form>
                                </td>

                            </tr>
                        <?php } }?>



                    </table>
                </div>
            </div>
            <div class="total">
                <p>Total Income: <?php  echo $totalIncome ?> </p>
            </div>
        </div>
        <div class="income-list-div">
            <p class="list">OUTCOME LIST</p>
            <div class="list-frame">
                <div class="table">
                    <table>
                        <tr>
                            <td class="table-header">Name</td>
                            <td class="table-header">Money</td>
                            <td class="table-header">Status</td>
                        </tr>
                        <?php foreach ($lists as  $list) { if ($list['inc_out'] == 'outcome') { ?>
                            <tr>
                                <td><?php echo $list['name']?></td>
                                <td><?php echo $list['money']?></td>
                                <td>
                                    <form action="actions.php" method="post">
                                        <input type="hidden" name="selected-name" value="<?php echo $list['name'] ?>">
                                        <span><input type="submit" name="edit" value="Edit"></span>
                                        <span><input type="submit" name="delete" value="Delete"></span>
                                    </form>
                                </td>

                            </tr>
                        <?php } }?>



                    </table>
                </div>
            </div>
            <div class="total">
                <p>Total Outcome: <?php echo $totalOutcome ?> </p>
            </div>
        </div>

        <div class="profit">
            <p>Profit: <?php echo $profit ?>  </p>
        </div>

    </div>

</div>


</body>
</html>