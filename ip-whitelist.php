<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = $mysqli->query("DELETE FROM `psec_ip-whitelist` WHERE id='$id'");
}
?>
<div class="content-wrapper">

    <!--CONTENT CONTAINER-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">القائمة البيضاء لعناوين IP</h1>
            <p class="txt-body-sm txt-secondary">إدارة عناوين IP الموثوقة التي تتجاوز نظام الحماية دون تصفية.</p>
        </div>
    </header>
    <div class="content"><div class="container-fluid">
<?php
if (isset($_POST['add'])) {
    $ip    = addslashes(htmlspecialchars($_POST['ip']));
    $notes = addslashes(htmlspecialchars($_POST['notes']));
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<div class="shield-card neon-host-card neon-border-pink" style="margin-bottom:var(--space-4);"><div class="shield-card__body"><span class="shield-badge shield-badge--critical" style="font-size: 1.1em;"><i data-lucide="alert-triangle" class="icon icon-sm neon-icon-animated micro-anim-zap" style="color: #D946EF; margin-left: 8px;"></i> عنوان IP غير صالح.</span></div></div>';
    } else {
        $queryvalid = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE ip='$ip' LIMIT 1");
        if (mysqli_num_rows($queryvalid) > 0) {
            echo '<div class="shield-card neon-host-card neon-border-info" style="margin-bottom:var(--space-4);"><div class="shield-card__body"><span class="shield-badge shield-badge--info" style="font-size: 1.1em;"><i data-lucide="info" class="icon icon-sm neon-icon-animated micro-anim-activity" style="color: #00B8E6; margin-left: 8px;"></i> عنوان IP موجود بالفعل.</span></div></div>';
        } else {
            $mysqli->query("INSERT INTO `psec_ip-whitelist` (ip, notes) VALUES('$ip', '$notes')");
        }
    }
}
?>
    <div class="shield-grid shield-grid--3" style="gap:var(--space-4);">
        <div style="grid-column:span 2;">
<?php
if (isset($_GET['edit-id'])) {
    $id  = (int)$_GET['edit-id'];
    $sql = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE id='$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id) || mysqli_num_rows($sql) == 0) { echo '<meta http-equiv="refresh" content="0; url=ip-whitelist.php">'; exit(); }
    if (isset($_POST['edit'])) {
        $ip    = addslashes(htmlspecialchars($_POST['ip']));
        $notes = $_POST['notes'];
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            echo '<div class="shield-card neon-host-card neon-border-pink" style="margin-bottom:var(--space-4);"><div class="shield-card__body"><span class="shield-badge shield-badge--critical" style="font-size: 1.1em;"><i data-lucide="alert-triangle" class="icon icon-sm neon-icon-animated micro-anim-zap" style="color: #D946EF; margin-left: 8px;"></i> عنوان IP غير صالح.</span></div></div>';
        } else {
            $qv = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE ip='$ip' AND id != '$id' LIMIT 1");
            if (mysqli_num_rows($qv) > 0) {
                echo '<div class="shield-card neon-host-card neon-border-info" style="margin-bottom:var(--space-4);"><div class="shield-card__body"><span class="shield-badge shield-badge--info" style="font-size: 1.1em;"><i data-lucide="info" class="icon icon-sm neon-icon-animated micro-anim-activity" style="color: #00B8E6; margin-left: 8px;"></i> عنوان IP موجود بالفعل.</span></div></div>';
            } else {
                $mysqli->query("UPDATE `psec_ip-whitelist` SET ip='$ip', `notes`='$notes' WHERE id='$id'");
                echo '<meta http-equiv="refresh" content="0; url=ip-whitelist.php">';
            }
        }
    }
?>
            <div class="shield-card neon-host-card neon-border-info" style="margin-bottom:var(--space-4);">
                <div class="shield-card__header"><i data-lucide="edit" class="icon icon-sm neon-icon-animated micro-anim-terminal" style="color: #00B8E6;"></i><span class="shield-card__title">تعديل عنوان IP</span></div>
                <form method="post" action="">
                <div class="shield-card__body">
                    <div style="margin-bottom:var(--space-3);">
                        <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-1);">عنوان IP</label>
                        <input type="text" name="ip" value="<?= $row['ip'] ?>" required style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                    </div>
                    <div>
                        <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-1);">ملاحظات</label>
                        <textarea name="notes" rows="3" style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);resize:none;"><?= $row['notes'] ?></textarea>
                    </div>
                </div>
                <div class="shield-card__footer" style="padding:var(--space-3);border-top:1px solid var(--border-subtle);display:flex;gap:var(--space-2);">
                    <button class="btn-shield-primary" name="edit" type="submit"><i data-lucide="save" class="icon icon-sm"></i> حفظ</button>
                    <button type="reset" class="btn-shield-secondary">إعادة تعيين</button>
                </div>
                </form>
            </div>
<?php } ?>
            <div class="shield-card neon-host-card neon-border-purple">
                <div class="shield-card__header"><i data-lucide="shield-check" class="icon icon-sm neon-icon-animated micro-anim-lock" style="color: #8B5CF6;"></i><span class="shield-card__title">القائمة البيضاء لعناوين IP</span></div>
                <div class="shield-card__body p-0">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basicphpconf" width="100%">
                            <thead><tr><th>عنوان IP</th><th>الملاحظات</th><th>الإجراءات</th></tr></thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_ip-whitelist`");
while ($row = $query->fetch_assoc()) {
    echo '<tr>
        <td data-label="عنوان IP">' . $row['ip'] . '</td>
        <td data-label="الملاحظات">' . $row['notes'] . '</td>
        <td data-label="الإجراءات">
            <a href="?edit-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="edit" class="icon icon-xs"></i> تعديل</a>
            <a href="?delete-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm" style="color:var(--color-critical);"><i data-lucide="trash" class="icon icon-xs"></i> حذف</a>
        </td></tr>';
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="shield-card neon-host-card neon-border-info">
                <div class="shield-card__header"><i data-lucide="plus-circle" class="icon icon-sm neon-icon-animated micro-anim-fingerprint" style="color: #00B8E6;"></i><span class="shield-card__title">إضافة عنوان IP</span></div>
                <form method="post" action="">
                <div class="shield-card__body">
                    <div style="margin-bottom:var(--space-3);">
                        <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-1);">عنوان IP</label>
                        <input type="text" name="ip" required placeholder="192.168.1.1" style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                    </div>
                    <div>
                        <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-1);">ملاحظات</label>
                        <textarea name="notes" rows="4" placeholder="يمكن إضافة معلومات توضيحية هنا" style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);resize:none;"></textarea>
                    </div>
                </div>
                <div class="shield-card__footer" style="padding:var(--space-3);border-top:1px solid var(--border-subtle);">
                    <button class="btn-shield-primary" name="add" type="submit" style="width:100%;justify-content:center;"><i data-lucide="plus" class="icon icon-sm"></i> إضافة</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div></div>
<?php else: ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 "><i class="fas fa-flag"></i> القائمة البيضاء لعناوين IP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">القائمة البيضاء لعناوين IP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

<?php
if (isset($_POST['add'])) {
    $ip    = addslashes(htmlspecialchars($_POST['ip']));
    $notes = addslashes(htmlspecialchars($_POST['notes']));

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<br />
        <div class="callout callout-danger">
            <p><i class="fas fa-exclamation-triangle"></i> عنوان <strong>IP</strong> المدخل غير صالح.</p>
        </div>';
    } else {
        $queryvalid = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE ip='$ip' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
            <div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> عنوان <strong>IP</strong> هذا موجود بالفعل في القائمة البيضاء.</p>
            </div>';
        } else {
            $query = $mysqli->query("INSERT INTO `psec_ip-whitelist` (ip, notes) VALUES('$ip', '$notes')");
        }
    }
}
?>
            <div class="row">
                <div class="col-md-9">

<?php
if (isset($_GET['edit-id'])) {
    $id    = (int) $_GET["edit-id"];
    $sql   = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE id = '$id'");
    $row   = mysqli_fetch_assoc($sql);

    if (empty($id) || mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=ip-whitelist.php">';
        exit();
    }

    if (isset($_POST['edit'])) {
        $ip    = addslashes(htmlspecialchars($_POST['ip']));
        $notes = $_POST['notes'];

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            echo '<br />
            <div class="callout callout-danger">
                <p><i class="fas fa-exclamation-triangle"></i> عنوان <strong>IP</strong> المدخل غير صالح.</p>
            </div>';
        } else {
            $queryvalid = $mysqli->query("SELECT * FROM `psec_ip-whitelist` WHERE ip='$ip' AND id != '$id' LIMIT 1");
            $validator  = mysqli_num_rows($queryvalid);
            if ($validator > "0") {
                echo '<br />
                <div class="callout callout-info">
                    <p><i class="fas fa-info-circle"></i> عنوان <strong>IP</strong> هذا موجود بالفعل في القائمة البيضاء.</p>
                </div>';
            } else {
                $query = $mysqli->query("UPDATE `psec_ip-whitelist` SET ip='$ip', `notes`='$notes' WHERE id='$id'");
                echo '<meta http-equiv="refresh" content="0; url=ip-whitelist.php">';
            }
        }
    }
?>
<form class="form-horizontal" action="" method="post">
    <div class="shield-card">
        <div class="shield-card">
            <h3 class="shield-card">تعديل عنوان IP</h3>
        </div>
        <div class="shield-card">
            <div class="form-group">
                <label class="control-label">عنوان IP: </label>
                <input type="text" name="ip" class="form-control" value="<?php echo $row['ip']; ?>" required>
            </div>
            <div class="form-group">
                <label class="control-label">ملاحظات: </label>
                <textarea rows="4" name="notes" class="form-control" placeholder="يمكن إضافة معلومات إضافية (توضيحية) هنا"><?php echo $row['notes']; ?></textarea>
            </div>
        </div>
        <div class="shield-card">
            <div class="col-md-8">
                <button class="btn btn-block btn-flat btn-success" name="edit" type="submit"><i class="fas fa-save"></i> حفظ</button>
            </div>
            <div class="col-md-4">
                <button type="reset" class="btn btn-block btn-flat btn-default"><i class="fas fa-undo"></i> إعادة تعيين</button>
            </div>
        </div>
    </div>
</form>
<?php } ?>

    <div class="shield-card">
        <div class="shield-card">
            <h3 class="shield-card">القائمة البيضاء لعناوين IP</h3>
        </div>
        <div class="shield-card">
            <table id="dt-basicphpconf" class="shield-table" width="100%">
                <thead class="<?php echo $thead; ?>">
                    <tr>
                        <th><i class="fas fa-user"></i> عنوان IP</th>
                        <th><i class="fas fa-clipboard"></i> الملاحظات</th>
                        <th><i class="fas fa-cog"></i> الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_ip-whitelist`");
while ($row = $query->fetch_assoc()) {
    echo '<tr>
        <td>' . $row['ip'] . '</td>
        <td>' . $row['notes'] . '</td>
        <td>
            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> تعديل</a>
            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> حذف</a>
        </td>
    </tr>';
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="shield-card">
        <div class="shield-card">
            <h3 class="shield-card">إضافة عنوان IP</h3>
        </div>
        <div class="shield-card">
            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="control-label">عنوان IP: </label>
                    <input type="text" name="ip" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">ملاحظات: </label>
                    <textarea rows="5" name="notes" class="form-control" placeholder="يمكن إضافة معلومات إضافية (توضيحية) هنا"></textarea>
                </div>
        </div>
        <div class="shield-card">
            <button class="btn btn-block btn-flat btn-primary" name="add" type="submit"><i class="fas fa-plus-square"></i> إضافة</button>
        </div>
    </div>
</form>
</div>
</div>

</div>
</div>
<?php endif; ?>
</div>
<?php footer(); ?>
