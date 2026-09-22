<?php
session_start();
require '../php/config.php';
require '../php/friend_functions.php';
require '../php/team_invite_functions.php';
require '../php/name_display.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['ajax'])) {
    $friends = get_friends_list($conn, $user_id);
    $pending = get_pending_requests($conn, $user_id);
    $team_invites = get_pending_team_invites($conn, $user_id);
    ob_start(); ?>

    <div class="friend-list box">
        <h2>Jouw vrienden</h2>
        <?php if (empty($friends)): ?>
            <p>Je hebt nog geen vrienden 😢</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($friends as $f): ?>
                    <li class="list-group-item"><?= htmlspecialchars($f['username']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="friend-requests box mt-4">
        <h4>Vriendschapsverzoeken</h4>
        <?php if (empty($pending)): ?>
            <p>Geen openstaande verzoeken.</p>
        <?php else: ?>
            <?php foreach ($pending as $p): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span><?= htmlspecialchars($p['username']) ?></span>
                    <div>
                        <button class="btn btn-success btn-sm me-1" onclick="handleFriendAction('accept', <?= $p['user_id'] ?>, event)">Accepteren</button>
                        <button class="btn btn-danger btn-sm" onclick="handleFriendAction('remove', <?= $p['user_id'] ?>, event)">Weigeren</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="team-invites box mt-4">
        <h4>Teamuitnodigingen</h4>
        <?php if (empty($team_invites)): ?>
            <p>Geen openstaande teamuitnodigingen.</p>
        <?php else: ?>
            <?php foreach ($team_invites as $invite): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span><strong><?= htmlspecialchars($invite['team_name']) ?></strong> — uitgenodigd door <?= htmlspecialchars($invite['leader_name']) ?></span>
                    <div>
                        <button class="btn btn-success btn-sm me-1" onclick="handleTeamAction('accept', <?= $invite['invite_id'] ?>, event)">Accepteren</button>
                        <button class="btn btn-danger btn-sm" onclick="handleTeamAction('reject', <?= $invite['invite_id'] ?>, event)">Weigeren</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php
    echo ob_get_clean();
    exit;
}

$friends = get_friends_list($conn, $user_id);
$pending = get_pending_requests($conn, $user_id);
$team_invites = get_pending_team_invites($conn, $user_id);
$search_results = [];

$stmt = $conn->prepare("
    SELECT t.team_id, t.name
    FROM teams t
    INNER JOIN team_members tm ON t.team_id = tm.team_id
    WHERE tm.user_id = ? AND tm.role = 'leader'
");
$stmt->execute([$user_id]);
$user_teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_results = search_users($conn, $user_id, trim($_GET['search']));
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vrienden & Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
<?php include '../php/navbar.php'; ?>

<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-10 mb-4">
            <div class="friend-list box">
                <h2>Jouw vrienden</h2>
                <?php if (empty($friends)): ?>
                    <p>Je hebt nog geen vrienden 😢</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($friends as $f): ?>
                            <li class="list-group-item"><?= htmlspecialchars($f['username']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-8 col-sm-10">
            <h2>Zoek spelers & verzoeken</h2>

            <form method="GET" class="mb-4 w-50">
                <div class="input-group">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    <input type="text" name="search" class="form-control"
                           placeholder="Zoek spelers..."
                           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </div>
            </form>

            <?php if (!empty($search_results)): ?>
                <div class="search-results box mb-4">
                    <h5>Zoekresultaten:</h5>
                    <ul class="list-group">
                        <?php foreach ($search_results as $u): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($u['username']) ?> (<?= htmlspecialchars($u['name']) ?>)</span>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm me-1" onclick="handleFriendAction('add', <?= $u['user_id'] ?>, event)">
                                        <i class="bi bi-person-plus"></i> Voeg toe
                                    </button>

                                    <?php if (!empty($user_teams)): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="bi bi-people"></i> Nodig uit
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($user_teams as $t): ?>
                                                    <li><a class="dropdown-item" href="#" onclick="handleTeamAction('send', <?= $u['user_id'] ?>, event, <?= $t['team_id'] ?>)">
                                                        <?= htmlspecialchars($t['name']) ?>
                                                    </a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif (isset($_GET['search'])): ?>
                <div class="alert alert-warning">Geen gebruikers gevonden met die naam.</div>
            <?php endif; ?>

            <div class="friend-requests box">
                <h4>Vriendschapsverzoeken</h4>
                <?php if (empty($pending)): ?>
                    <p>Geen openstaande verzoeken.</p>
                <?php else: ?>
                    <?php foreach ($pending as $p): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?= htmlspecialchars($p['username']) ?></span>
                            <div>
                                <button class="btn btn-success btn-sm me-1" onclick="handleFriendAction('accept', <?= $p['user_id'] ?>, event)">Accepteren</button>
                                <button class="btn btn-danger btn-sm" onclick="handleFriendAction('remove', <?= $p['user_id'] ?>, event)">Weigeren</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="team-invites box mt-4">
                <h4>Teamuitnodigingen</h4>
                <?php if (empty($team_invites)): ?>
                    <p>Geen openstaande teamuitnodigingen.</p>
                <?php else: ?>
                    <?php foreach ($team_invites as $invite): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><strong><?= htmlspecialchars($invite['team_name']) ?></strong> — uitgenodigd door <?= htmlspecialchars($invite['leader_name']) ?></span>
                            <div>
                                <button class="btn btn-success btn-sm me-1" onclick="handleTeamAction('accept', <?= $invite['invite_id'] ?>, event)">Accepteren</button>
                                <button class="btn btn-danger btn-sm" onclick="handleTeamAction('reject', <?= $invite['invite_id'] ?>, event)">Weigeren</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../php/footer.php'; ?>

<script>
    function handleTeamAction(action, targetId, event, teamId = null) {
        if (event) event.preventDefault();

        let body = `action=${action}`;
        if (targetId) body += `&target_id=${targetId}`;
        if (teamId) body += `&team_id=${teamId}`;

        fetch('../php/team_invite_actions.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(refreshFriendLists, 300);
            } else {
                showToast(data.error, 'error');
            }
        })
        .catch(() => showToast('Fout bij verbinding met server', 'error'));
    }

    function handleFriendAction(action, friendId, event) {
        if (event) event.preventDefault();
        fetch('../php/friend_actions.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=${action}&friend_id=${friendId}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(refreshFriendLists, 300);
            } else {
                showToast(data.error, 'error');
            }
        })
        .catch(() => showToast('Fout bij verbinding met server', 'error'));
    }

    function refreshFriendLists() {
        fetch('friends.php?ajax=1')
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                document.querySelector('.friend-list').innerHTML = doc.querySelector('.friend-list').innerHTML;
                document.querySelector('.friend-requests').innerHTML = doc.querySelector('.friend-requests').innerHTML;
                document.querySelector('.team-invites').innerHTML = doc.querySelector('.team-invites').innerHTML;
            });
    }

    function showToast(message, type = 'success') {
        const oldToast = document.getElementById('friend-toast');
        if (oldToast) oldToast.remove();
        const toast = document.createElement('div');
        toast.id = 'friend-toast';
        toast.className = `toast-message ${type}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 5000);
    }
</script>

<style>
.toast-message {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background-color: #198754;
    color: #fff;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    opacity: 0;
    transform: translateY(15px);
    transition: all 0.5s ease;
    z-index: 9999;
}
.toast-message.error { background-color: #dc3545; }
.toast-message.show { opacity: 1; transform: translateY(0); }
</style>
</body>
</html>
