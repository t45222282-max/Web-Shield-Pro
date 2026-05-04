<?php
require "core.php";
head();

if (isset($_GET['id'])) {
    $id     = (int) $_GET["id"];

    $result = $mysqli->query("SELECT * FROM `psec_logs` WHERE id = '$id'");
    $row    = mysqli_fetch_assoc($result);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=all-logs.php">';
        exit();
    }
    if (mysqli_num_rows($result) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=all-logs.php">';
        exit();
    }
	
    $ip = $row['ip'];
	if (isset($_GET['ban-ip'])) {
    
        $ip       = addslashes(htmlspecialchars($ip));
        $date     = date("d F Y");
        $time     = date("H:i");
        $reason   = $row['type'];
        $redirect = 0;
        $url      = "";
    
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $queryvalid = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
            $validator  = mysqli_num_rows($queryvalid);
                if ($validator <= "0") {
                    $query = $mysqli->query("INSERT INTO `psec_bans` (`ip`, `date`, `time`, `reason`, `redirect`, `url`) VALUES ('$ip', '$date', '$time', '$reason', '$redirect', '$url')");
                }
            }
        }

        if (isset($_GET['unban-ip'])) {
            $ip    = addslashes(htmlspecialchars($ip));
			
            $query = $mysqli->query("DELETE FROM `psec_bans` WHERE ip='$ip'");
        }
?>  
<div class="content-wrapper">

<!--CONTENT CONTAINER-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">تفاصيل السجل</h1>
            <p class="txt-body-sm txt-secondary">عرض تفاصيل محاولة الاختراق أو الزيارة وتحديث الحظر المطبق.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">

            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <i data-lucide="file-text" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">سجل #<?php echo $row['id']; ?> - التفاصيل</span>
                    </div>
                    <div style="display: flex; gap: var(--space-2);">
<?php
    if (get_banned($row['ip']) == 1) {
        echo '<a href="log-details.php?id=' . $row['id'] . '&unban-ip" class="btn-shield-success"><i data-lucide="unlock" class="icon icon-sm"></i> إلغاء الحظر (Unban IP)</a>';
    } else {
        echo '<a href="log-details.php?id=' . $row['id'] . '&ban-ip" class="btn-shield-warning"><i data-lucide="ban" class="icon icon-sm"></i> حظر الـ IP</a>';
    }
    echo '<a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn-shield-secondary" style="color: var(--color-critical); border-color: var(--color-critical);"><i data-lucide="trash" class="icon icon-sm"></i> حذف السجل</a>';
?>
                    </div>
                </div>
                <div class="shield-card__body">
                    <div class="shield-grid shield-grid--2" style="gap: var(--space-4);">
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="user" class="icon icon-xs"></i> IP Address
                            </label>
                            <input type="text" value="<?php echo $row['ip']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="calendar" class="icon icon-xs"></i> Date and Time
                            </label>
                            <input type="text" value="<?php echo '' . $row['date'] . ' at ' . $row['time'] . ''; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>
                        
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="globe" class="icon icon-xs"></i> Browser
                            </label>
                            <div style="display: flex; align-items: center; border: 1px solid var(--border-default); background: var(--bg-surface-3); padding: var(--space-2); border-radius: var(--radius-sm);">
                                <span style="margin-left: var(--space-2);">
                                    <img src="assets/img/icons/browser/<?php echo $row['browser_code']; ?>.png" />
                                </span>
                                <input type="text" value="<?php echo $row['browser']; ?>" readonly style="border: none; background: transparent; color: var(--text-primary); width: 100%; outline: none;">
                            </div>
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="monitor" class="icon icon-xs"></i> Operating System
                            </label>
                            <div style="display: flex; align-items: center; border: 1px solid var(--border-default); background: var(--bg-surface-3); padding: var(--space-2); border-radius: var(--radius-sm);">
                                <span style="margin-left: var(--space-2);">
                                    <img src="assets/img/icons/os/<?php echo $row['os_code']; ?>.png" />
                                </span>
                                <input type="text" value="<?php echo $row['os']; ?>" readonly style="border: none; background: transparent; color: var(--text-primary); width: 100%; outline: none;">
                            </div>
                        </div>
                        
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="flag" class="icon icon-xs"></i> Country
                            </label>
                            <div style="display: flex; align-items: center; border: 1px solid var(--border-default); background: var(--bg-surface-3); padding: var(--space-2); border-radius: var(--radius-sm);">
                                <span style="margin-left: var(--space-2);">
                                    <img src="assets/plugins/flags/blank.png" class="flag flag-<?php echo strtolower($row['country_code']); ?>" alt="<?php echo $row['country']; ?>" />
                                </span>
                                <input type="text" value="<?php echo $row['country']; ?>" readonly style="border: none; background: transparent; color: var(--text-primary); width: 100%; outline: none;">
                            </div>
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="map-pin" class="icon icon-xs"></i> Region
                            </label>
                            <input type="text" value="<?php echo $row['region']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>

                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="map" class="icon icon-xs"></i> City
                            </label>
                            <input type="text" value="<?php echo $row['city']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="cloud" class="icon icon-xs"></i> Internet Service Provider
                            </label>
                            <input type="text" value="<?php echo $row['isp']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>

                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="alert-triangle" class="icon icon-xs"></i> Threat Type
                            </label>
                            <input type="text" value="<?php echo $row['type']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm); color: var(--color-warning);">
                        </div>
                        <div>
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="corner-up-left" class="icon icon-xs"></i> Referer URL
                            </label>
                            <input type="text" value="<?php echo $row['referer_url']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>

                        <div style="grid-column: span 2;">
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="user-check" class="icon icon-xs"></i> User Agent
                            </label>
                            <textarea rows="2" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm); font-family: var(--font-mono); font-size: 0.85em; resize: none;"><?php echo $row['useragent']; ?></textarea>
                        </div>
                    </div>
                    
                    <hr style="border-top: 1px solid var(--border-subtle); margin: var(--space-4) 0;" />
                    
                    <div class="shield-grid shield-grid--3" style="gap: var(--space-4);">
                        <div style="grid-column: span 1;">
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="file" class="icon icon-xs"></i> Attacked Page
                            </label>
                            <input type="text" value="<?php echo $row['page']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                        </div>
                        <div style="grid-column: span 2;">
                            <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                <i data-lucide="code" class="icon icon-xs"></i> Query used for the attack
                            </label>
                            <textarea rows="2" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm); font-family: var(--font-mono); font-size: 0.85em; resize: none;"><?php echo $row['query']; ?></textarea>
                        </div>
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
        		      <h4 class="m-0"><i class="fas fa-align-justify"></i> Log Details</h4>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Log Details</li>
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
							<h3 class="shield-card"><i class="fas fa-file-alt"></i> <b>Log #<?php
    echo $row['id'];
?></b> - Details</h3>&nbsp;&nbsp;&nbsp;
                            <div class="float-sm-right">
<?php
    if (get_banned($row['ip']) == 1) {
        echo '
										    <a href="log-details.php?id=' . $row['id'] . '&unban-ip" class="btn btn-flat btn-success btn-sm"><i class="fas fa-ban"></i> Unban IP</a>
									        ';
    } else {
        echo '
										    <a href="log-details.php?id=' . $row['id'] . '&ban-ip" class="btn btn-flat btn-warning btn-sm"><i class="fas fa-ban"></i> Ban IP</a>
									        ';
    }
    echo '
											<a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> Delete Log</a>
';
?>
                            </div>
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
                                                        <i class="fas fa-calendar"></i> Date and Time
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
                                                         <i class="fas fa-map-pin"></i> Region
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['region'];
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-map"></i> City
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['city'];
?>" readonly>
												</div>
											</div>
                                            <div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-cloud"></i> Internet Service Provider
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['isp'];
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-exclamation-triangle"></i> Threat Type
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo $row['type'];
?>" readonly>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
                                                    <label class="control-label">
                                                        <i class="fas fa-reply"></i> Referer URL
                                                    </label>
                                                    <input type="text" class="form-control" value="<?php
    echo $row['referer_url'];
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        <hr />
                                        <div class="row">
											<div class="col-sm-4">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-file-alt"></i> Attacked Page
                                                </label>
                                                <input type="text" class="form-control" value="<?php
    echo $row['page'];
?>" readonly>
                                            </div>
                                            </div>	
                                            <div class="col-sm-8">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-code"></i> Query used for the attack
                                                </label>
                                                <textarea placeholder="Query" rows="2" class="form-control" readonly><?php
    echo $row['query'];
?></textarea>
                                            </div>
                                            </div>
										</div>
                            
                                       
                     </div>
                </div>
				</div>
                    
				</div>
				</div>
<?php endif; ?>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>

<script type="text/javascript">

    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

    var lonLat = new OpenLayers.LonLat(<?php
    echo $row['longitude'];
?>, <?php
    echo $row['latitude'];
?>)
        .transform(
            new OpenLayers.Projection("EPSG:4326"),
            map.getProjectionObject()
        );
          
    var zoom = 18;
    var markers = new OpenLayers.Layer.Markers("Markers");
	
    map.addLayer(markers);
    markers.addMarker(new OpenLayers.Marker(lonLat));
    map.setCenter(lonLat, zoom);
</script>
<?php
    footer();
} else {
    echo '<meta http-equiv="refresh" content="0; url=all-logs.php">';
    exit();
}
?>