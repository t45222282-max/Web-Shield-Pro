<?php
require "core.php";
head();

if (isset($_GET['id'])) {
    $id     = (int) $_GET["id"];

    $result = $mysqli->query("SELECT * FROM `psec_live-traffic` WHERE id = '$id'");
    $row    = mysqli_fetch_assoc($result);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=live-traffic.php">';
        exit();
    }
    if (mysqli_num_rows($result) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=live-traffic.php">';
        exit();
    }
?>  
<div class="content-wrapper">

<!--CONTENT CONTAINER-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">تفاصيل الزائر</h1>
            <p class="txt-body-sm txt-secondary">عرض تفاصيل زيارة محددة ضمن سجل حركة المرور.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="info" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">تفاصيل الزيارة #<?php echo $row['id']; ?></span>
                </div>
                <div class="shield-card__body">
                    <div class="shield-grid shield-grid--2" style="gap: var(--space-4);">
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="user" class="icon icon-xs"></i> IP Address</label>
                            <input type="text" value="<?php echo $row['ip']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="calendar" class="icon icon-xs"></i> Date and Time</label>
                            <input type="text" value="<?php echo $row['date'] . ' at ' . $row['time']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="globe" class="icon icon-xs"></i> Browser</label>
                            <div style="display:flex;align-items:center;border:1px solid var(--border-default);background:var(--bg-surface-3);padding:var(--space-2);border-radius:var(--radius-sm);">
                                <img src="assets/img/icons/browser/<?php echo $row['browser_code']; ?>.png" style="margin-left:var(--space-2);" />
                                <input type="text" value="<?php echo $row['browser']; ?>" readonly style="border:none;background:transparent;color:var(--text-primary);width:100%;outline:none;">
                            </div>
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="monitor" class="icon icon-xs"></i> Operating System</label>
                            <div style="display:flex;align-items:center;border:1px solid var(--border-default);background:var(--bg-surface-3);padding:var(--space-2);border-radius:var(--radius-sm);">
                                <img src="assets/img/icons/os/<?php echo $row['os_code']; ?>.png" style="margin-left:var(--space-2);" />
                                <input type="text" value="<?php echo $row['os']; ?>" readonly style="border:none;background:transparent;color:var(--text-primary);width:100%;outline:none;">
                            </div>
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="flag" class="icon icon-xs"></i> Country</label>
                            <div style="display:flex;align-items:center;border:1px solid var(--border-default);background:var(--bg-surface-3);padding:var(--space-2);border-radius:var(--radius-sm);">
                                <img src="assets/plugins/flags/blank.png" class="flag flag-<?php echo strtolower($row['country_code']); ?>" alt="<?php echo $row['country']; ?>" style="margin-left:var(--space-2);" />
                                <input type="text" value="<?php echo $row['country']; ?>" readonly style="border:none;background:transparent;color:var(--text-primary);width:100%;outline:none;">
                            </div>
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="map-pin" class="icon icon-xs"></i> Country Code</label>
                            <input type="text" value="<?php echo $row['country_code']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="smartphone" class="icon icon-xs"></i> Device Type</label>
                            <input type="text" value="<?php echo $row['device_type']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="link-2" class="icon icon-xs"></i> Domain</label>
                            <input type="text" value="<?php echo $row['domain']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div style="grid-column:span 2;">
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="link" class="icon icon-xs"></i> Visited Page</label>
                            <input type="text" value="<?php echo $row['request_uri']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                    </div>
                    <hr style="border-top:1px solid var(--border-subtle);margin:var(--space-4) 0;" />
                    <div class="shield-grid shield-grid--3" style="gap:var(--space-4);">
                        <div style="grid-column:span 1;">
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="cpu" class="icon icon-xs"></i> Bot</label>
                            <input type="text" value="<?php echo $row['bot'] == 1 ? 'Yes' : 'No'; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                        </div>
                        <div style="grid-column:span 2;">
                            <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="user-check" class="icon icon-xs"></i> User Agent</label>
                            <textarea rows="2" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);font-family:var(--font-mono);font-size:0.85em;resize:none;"><?php echo $row['useragent']; ?></textarea>
                        </div>
                    </div>
                    <div style="margin-top:var(--space-4);">
                        <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="corner-up-left" class="icon icon-xs"></i> Referer URL</label>
                        <input type="text" value="<?php echo $row['referer']; ?>" readonly style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-align-justify"></i> Visitor Details</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Visitor Details</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                <div class="row">
				<div class="col-md-12">
				    <div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card">Details for Visit #<?php
    echo $row['id'];
?></h3>
						</div>
						<div class="shield-card">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-user"></i> IP Address
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['ip'];
?>" readonly>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-calendar-alt"></i> Date and Time
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo '' . $row['date'] . ' at ' . $row['time'] . '';
?>" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-globe"></i> Browser
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="assets/img/icons/browser/<?php
    echo $row['browser_code'];
?>.png" />
                                                        </span>
													   <input type="text" class="form-control" value="<?php
    echo $row['browser'];
?>" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-desktop"></i> Operating System
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="assets/img/icons/os/<?php
    echo $row['os_code'];
?>.png" />
                                                        </span>
                                                        <input type="text" class="form-control" value="<?php
    echo $row['os'];
?>" readonly>
                                                    </div>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-flag"></i> Country
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="assets/plugins/flags/blank.png" class="flag flag-<?php
    echo strtolower($row['country_code']);
?>" alt="<?php
    echo $row['country'];
?>" />
                                                        </span>
                                                        <input type="text" class="form-control" value="<?php
    echo $row['country'];
?>" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-map-pin"></i> Country Code
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['country_code'];
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-mobile-alt"></i> Device Type
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['device_type'];
?>" readonly>
												</div>
											</div>
                                            <div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-atlas"></i> Domain
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['domain'];
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
                                        <div class="col-sm-12">
											<label class="control-label">
                                                <i class="fas fa-link"></i> Visited Page
                                            </label>
                                            <input type="text" class="form-control" value="<?php
    echo $row['request_uri'];
?>" readonly>
										</div>
                                        </div><br />
                                        <div class="row">
                                            <div class="col-sm-4">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-robot"></i> Bot
                                                </label>
                                                <input type="text" class="form-control" value="
<?php
    if ($row['bot'] == 1) {
        echo 'Yes';
    } else {
        echo 'No';
    }
?>
												" readonly>
                                            </div>
                                            </div>
                                            <div class="col-sm-8">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-user-secret"></i> User Agent
                                                </label>
                                                <textarea placeholder="User Agent" rows="2" class="form-control" readonly><?php
    echo $row['useragent'];
?></textarea>
                                            </div>
                                            </div>	
										</div>
										<div class="row">
                                        <div class="col-sm-12">
											<label class="control-label">
                                                <i class="fas fa-reply"></i> Referer URL
                                            </label>
                                            <input type="text" class="form-control" value="<?php
    echo $row['referer'];
?>" readonly>
										</div>
                                        </div>

									</div>
                     </div>
                </div>
				</div>
                    
				</div>
				</div>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
<?php endif; ?>
</div>
<?php
    footer();
} else {
    echo '<meta http-equiv="refresh" content="0; url=live-traffic.php">';
    exit();
}
?>