<?php
/**
 * $types = ['success', 'info', 'warning', 'danger'];
 */
?><div class="alert alert-<?= isset($type) ? $type : 'info'; ?>" role="alert"><?=$text;?></div>
