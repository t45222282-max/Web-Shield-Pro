<?php
require "core.php";
head();

if (isset($_POST['ersave'])) {

    $settings['error_reporting'] = $_POST['erselect'];
    $settings['display_errors']  = $_POST['deselect'];
    
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">مراقبة الأخطاء</h1>
            <p class="txt-body-sm txt-secondary">إدارة إعدادات الأخطاء وعرض سجلات الخادم.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">
            
            <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
                <div style="grid-column: span 2;">
                    <form method="post">
                        <div class="shield-card" style="margin-bottom: var(--space-6);">
                            <div class="shield-card__header">
                                <i data-lucide="settings" class="icon icon-sm text-brand"></i>
                                <span class="shield-card__title">إعدادات (Settings)</span>
                            </div>
                            <div class="shield-card__body">
                                <div class="shield-grid shield-grid--2">
                                    <div>
                                        <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                            <i data-lucide="bug" class="icon icon-xs"></i> Error Reporting
                                        </label>
                                        <select class="form-control" name="erselect" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                                            <option value="1" <?php if ($settings['error_reporting'] == 1) echo 'selected="selected" '; ?>>Turned Off</option>
                                            <option value="2" <?php if ($settings['error_reporting'] == 2) echo 'selected="selected" '; ?>>Report simple running errors</option>
                                            <option value="3" <?php if ($settings['error_reporting'] == 3) echo 'selected="selected" '; ?>>Report simple running errors + notices</option>
                                            <option value="4" <?php if ($settings['error_reporting'] == 4) echo 'selected="selected" '; ?>>Report all errors except notices</option>
                                            <option value="5" <?php if ($settings['error_reporting'] == 5) echo 'selected="selected" '; ?>>Report all errors (Recommended)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="txt-body-sm font-medium" style="display: block; margin-bottom: var(--space-2);">
                                            <i data-lucide="eye" class="icon icon-xs"></i> Errors Visibility
                                        </label>
                                        <select class="form-control" name="deselect" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                                            <option value="0" <?php if ($settings['display_errors'] == 0) echo 'selected="selected" '; ?>>Hide Errors (Recommended)</option>
                                            <option value="1" <?php if ($settings['display_errors'] == 1) echo 'selected="selected" '; ?>>Display Errors</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="shield-card__footer" style="padding: var(--space-4); border-top: 1px solid var(--border-subtle); background: var(--bg-surface-2);">
                                <button class="btn-shield-primary" name="ersave" type="submit" style="width: 100%; justify-content: center;">
                                    <i data-lucide="save" class="icon icon-sm"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="shield-card">
                        <div class="shield-card__header">
                            <i data-lucide="clipboard-list" class="icon icon-sm text-brand"></i>
                            <span class="shield-card__title">سجل الأخطاء (Error Monitoring)</span>
                        </div>
                        <div class="shield-card__body p-0">
<?php
$log_errors = ini_get('log_errors');

if (!$log_errors)
    echo '<div style="background: var(--color-info); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin: var(--space-4);"><i data-lucide="info" class="icon icon-sm"></i> Error Logging is disabled on your server</div>';

$error_log = ini_get('error_log');
$logs      = array(
    $error_log
);
$count     = 10000;
$lines     = array();

foreach ($logs as $log) {
    if (@is_readable($log))
        $lines = array_merge($lines, last_lines($log, $count));
}

$lines = array_map('trim', $lines);
$lines = array_filter($lines);

foreach ($lines as $key => $line) {
    if (false != strpos($line, ']'))
        list($time, $error) = explode(']', $line, 2);
    else
        list($time, $error) = array(
            '',
            $line
        );
    
    $time        = trim($time, '[]');
    $error       = trim($error);
    $lines[$key] = compact('time', 'error');
}
?>
                            <div class="shield-table-wrapper">
                                <table class="shield-table" id="dt-basicphpconf" width="100%">
                                    <thead>
                                        <tr>
                                            <th>التاريخ والوقت (Date & Time)</th>
                                            <th>الخطأ (Error)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
foreach ($lines as $line) {
    $error = $line['error'];
    $time  = $line['time'];
    
    if (!empty($error))
        echo ("<tr><td data-label=\"التاريخ والوقت (Date & Time)\">{$time}</td><td data-label=\"الخطأ (Error)\" style=\"font-family: var(--font-mono); font-size: 0.85em; color: var(--color-critical); word-break: break-all;\">{$error}</td></tr>");
}
?>
                                    </tbody>
                                </table>
                            </div>
<?php
// Compare callback for freeform date/time strings.
function time_field_compare($a, $b)
{
    if ($a == $b)
        return 0;
    return (strtotime($a['time']) > strtotime($b['time'])) ? -1 : 1;
}

// Reads lines from end of file. Memory-safe.
function last_lines($path, $line_count, $block_size = 512)
{
    $lines = array();
    $leftover = '';
    
    $fh = fopen($path, 'r');
    // Go to the end of the file
    fseek($fh, 0, SEEK_END);
    
    do {
        // need to know whether we can actually go back
        // $block_size bytes
        $can_read = $block_size;
        
        if (ftell($fh) <= $block_size)
            $can_read = ftell($fh);
        
        if (empty($can_read))
            break;
        
        // go back as many bytes as we can
        // read them to $data and then move the file pointer
        // back to where we were.
        fseek($fh, -$can_read, SEEK_CUR);
        $data = fread($fh, $can_read);
        $data .= $leftover;
        fseek($fh, -$can_read, SEEK_CUR);
        
        // split lines by \n. Then reverse them,
        // now the last line is most likely not a complete
        // line which is why we do not directly add it, but
        // append it to the data read the next time.
        $split_data = array_reverse(explode("\n", $data));
        $new_lines  = array_slice($split_data, 0, -1);
        $lines      = array_merge($lines, $new_lines);
        $leftover   = $split_data[count($split_data) - 1];
    } while (count($lines) < $line_count && ftell($fh) != 0);
    
    if (ftell($fh) == 0)
        $lines[] = $leftover;
    
    fclose($fh);
    // Usually, we will read too many lines, correct that here.
    return array_slice($lines, 0, $line_count);
}
?>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="shield-card">
                        <div class="shield-card__header">
                            <i data-lucide="info" class="icon icon-sm text-brand"></i>
                            <span class="shield-card__title">Information & Tips</span>
                        </div>
                        <div class="shield-card__body">
                            <p class="txt-body-sm txt-secondary" style="margin-bottom: var(--space-4);">
                                Logging errors is recommended best practice, even for production site. Checking those logs however might seem like a chore. The error monitoring brings all entries from error log on this page.
                            </p>
                            <ul class="txt-body-sm txt-secondary" style="padding-left: var(--space-4); display: flex; flex-direction: column; gap: var(--space-2);">
                                <li style="list-style-type: disc;">The log file is detected automatically from the configuration of the server</li>
                                <li style="list-style-type: disc;">Only the end of file is read - no memory overflow issues, safe for large logs</li>
                                <li style="list-style-type: disc;">Optimized to work smoothly even with very large log files</li>    
                            </ul>
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
        		      <h1 class="m-0 "><i class="fas fa-exclamation-circle"></i> Error Monitoring</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Error Monitoring</li>
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
				<div class="col-md-9">
				        <div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card"><i class="fas fa-cogs"></i> Settings</h3>
						</div>
						<div class="shield-card">

                            <form method="post">
								<div class="row">
								<div class="col-md-6">
									<label><i class="fas fa-bug"></i> Error Reporting</label>
									<select class="form-control" name="erselect" class="width100">
										<option value="1" <?php
	if ($settings['error_reporting'] == 1)
		echo 'selected="selected" ';
	?>>Turned Off</option>
										<option value="2" <?php
	if ($settings['error_reporting'] == 2)
		echo 'selected="selected" ';
	?>>Report simple running errors</option>
										<option value="3" <?php
	if ($settings['error_reporting'] == 3)
		echo 'selected="selected" ';
	?>>Report simple running errors + notices</option>
										<option value="4" <?php
	if ($settings['error_reporting'] == 4)
		echo 'selected="selected" ';
	?>>Report all errors except notices</option>
										<option value="5" <?php
	if ($settings['error_reporting'] == 5)
		echo 'selected="selected" ';
	?>>Report all errors (Recommended)</option>
									</select>
								</div>
								<div class="col-md-6">
									<label><i class="fas fa-eye"></i> Errors Visibility</label>
									<select class="form-control" name="deselect" class="width100">
										<option value="0" <?php
	if ($settings['display_errors'] == 0)
		echo 'selected="selected" ';
	?>>Hide Errors (Recommended)</option>
										<option value="1" <?php
	if ($settings['display_errors'] == 1)
		echo 'selected="selected" ';
	?>>Display Errors</option>
									</select>
								</div>
								</div><br />
								
		                        <input class="btn btn-primary btn-block btn-flat" type="submit" name="ersave" value="Save" />
		                    </form>
						</div>
						</div>
			    
				        <div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card"><i class="fas fa-clipboard-list"></i> Error Monitoring</h3>
						</div>
						<div class="shield-card">
<?php
$log_errors = ini_get('log_errors');

if (!$log_errors)
    echo '<div class="alert alert-info">Error Logging is disabled on your server</div>';

$error_log = ini_get('error_log');
$logs      = array(
    $error_log
);
$count     = 10000;
$lines     = array();

foreach ($logs as $log) {
    if (@is_readable($log))
        $lines = array_merge($lines, last_lines($log, $count));
}

$lines = array_map('trim', $lines);
$lines = array_filter($lines);

foreach ($lines as $key => $line) {
    if (false != strpos($line, ']'))
        list($time, $error) = explode(']', $line, 2);
    else
        list($time, $error) = array(
            '',
            $line
        );
    
    $time        = trim($time, '[]');
    $error       = trim($error);
    $lines[$key] = compact('time', 'error');
}
?>
        <table id="dt-basicphpconf" class="shield-table" width="100%">
        <thead class="<?php echo $thead; ?>">
			<tr>
				<th><i class="fas fa-calendar"></i> Date & Time</th>
				<th><i class="fas fa-exclamation-circle"></i> Error</th>
			</tr>
		</thead>
        <tbody>
        <?php
foreach ($lines as $line) {
    $error = $line['error'];
    $time  = $line['time'];
    
    if (!empty($error))
        echo ("<tr><td>{$time}</td><td>{$error}</td></tr>");
}
?>
            </tbody>
        </table> 
<?php
// Compare callback for freeform date/time strings.
function time_field_compare($a, $b)
{
    if ($a == $b)
        return 0;
    return (strtotime($a['time']) > strtotime($b['time'])) ? -1 : 1;
}

// Reads lines from end of file. Memory-safe.
function last_lines($path, $line_count, $block_size = 512)
{
    $lines = array();
    $leftover = '';
    
    $fh = fopen($path, 'r');
    // Go to the end of the file
    fseek($fh, 0, SEEK_END);
    
    do {
        // need to know whether we can actually go back
        // $block_size bytes
        $can_read = $block_size;
        
        if (ftell($fh) <= $block_size)
            $can_read = ftell($fh);
        
        if (empty($can_read))
            break;
        
        // go back as many bytes as we can
        // read them to $data and then move the file pointer
        // back to where we were.
        fseek($fh, -$can_read, SEEK_CUR);
        $data = fread($fh, $can_read);
        $data .= $leftover;
        fseek($fh, -$can_read, SEEK_CUR);
        
        // split lines by \n. Then reverse them,
        // now the last line is most likely not a complete
        // line which is why we do not directly add it, but
        // append it to the data read the next time.
        $split_data = array_reverse(explode("\n", $data));
        $new_lines  = array_slice($split_data, 0, -1);
        $lines      = array_merge($lines, $new_lines);
        $leftover   = $split_data[count($split_data) - 1];
    } while (count($lines) < $line_count && ftell($fh) != 0);
    
    if (ftell($fh) == 0)
        $lines[] = $leftover;
    
    fclose($fh);
    // Usually, we will read too many lines, correct that here.
    return array_slice($lines, 0, $line_count);
}

?>
                              </div>
						   </div>
                        </div>
						<div class="col-md-3">
							<div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card"><i class="fas fa-info-circle"></i> Information & Tips</h3>
						</div>
						<div class="shield-card">
									Logging errors is recommended best practice, even for production site. Checking those logs however might seem like a chore. The error monitoring brings all entries from error log on this page.<br /><br />
                                    <ul>
                                    <li>The log file is detected automatically from the configuration of the server</li>
                                    <li>Only the end of file is read - no memory overflow issues, safe for large logs</li>
                                    <li>Optimized to work card card-body bg-light even with very large log files</li>    
                                    </ul>
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
<?php
footer();
?>