<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of Dotclear 2.
#
# Copyright (c) 2012 Franck Paul
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */				__("myFavs"),
	/* Description*/		__("Add favorite capabilities to all plugins"),
	/* Author */			"Franck Paul",
	/* Version */			'0.1',
	array(
		'priority' =>	999999999
	)
);
?>