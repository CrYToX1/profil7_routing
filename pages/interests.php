<?php
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $pdo->prepare("INSERT INTO interests (name) VALUES (?)");
            $stmt->execute([$name]);
            header("Location: index.php?page=interests&msg=added");
            exit;
        } else {
            $msg = "Zájem nesmí být prázdný!";
        }
    } elseif (isset($_POST['edit'])) {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $pdo->prepare("UPDATE interests SET name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
            header("Location: index.php?page=interests&msg=edited");
            exit;
        }
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM interests WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php?page=interests&msg=deleted");
        exit;
    }
}

$stmt = $pdo->query("SELECT * FROM interests ORDER BY id");
$interests = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'added':  $msg = "Zájem přidán!"; break;
        case 'edited': $msg = "Zájem upraven!"; break;
        case 'deleted':$msg = "Zájem smazán!"; break;
    }
}
?>
<h1>Zájmy</h1>
<?php if ($msg): ?><p style="color:green;font-weight:bold;"><?php echo $msg; ?></p><?php endif; ?>

<h2>Přidat zájem</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Název zájmu" required>
    <button type="submit" name="add">Přidat</button>
</form>

<h2>Seznam zájmů</h2>
<?php if (empty($interests)): ?>
    <p>Žádné zájmy zatím.</p>
<?php else: ?>
<ul>
<?php foreach ($interests as $key => $i): ?>
    <li>
        <?php echo ($key + 1)?>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $i['id']; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($i['name']); ?>" required>
            <button type="submit" name="edit">Upravit</button>
        </form>
        <form method="POST" style="display:inline;" onsubmit="return confirm('Opravdu smazat?');">
            <input type="hidden" name="id" value="<?php echo $i['id']; ?>">
            <button type="submit" name="delete">Smazat</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>