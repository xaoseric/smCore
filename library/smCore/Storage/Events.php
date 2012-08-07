<?php

/**
 * smCore Storage - Events
 *
 * @package smCore
 * @author smCore Dev Team
 * @license MPL 1.1
 * @version 1.0 Alpha
 *
 * The contents of this file are subject to the Mozilla Public License Version 1.1
 * (the "License"); you may not use this package except in compliance with the
 * License. You may obtain a copy of the License at http://www.mozilla.org/MPL/
 *
 * The Original Code is smCore.
 *
 * The Initial Developer of the Original Code is the smCore project.
 *
 * Portions created by the Initial Developer are Copyright (C) 2011
 * the Initial Developer. All Rights Reserved.
 */

namespace smCore\Storage;

use smCore\Application;

class Events
{
	public function getActiveListeners()
	{
		$cache = Application::get('cache');

		if (false === $events = $cache->load('smcore_active_listeners'))
		{
			$db = Application::get('db');
			$events = array();

			$result = $db->query("
				SELECT *
				FROM {db_prefix}event_listeners
				WHERE listener_enabled = 1"
			);

			if ($result->rowCount() > 0)
			{
				$events = $result->fetchAll();
			}

			$cache->save('smcore_active_listeners', $events);
		}

		return $events;
	}
}