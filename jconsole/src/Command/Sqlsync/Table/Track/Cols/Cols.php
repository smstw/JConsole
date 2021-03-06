<?php
/**
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Command\Sqlsync\Table\Track\Cols;

use Command\Sqlsync\Table\Track\All\All;

defined('JPATH_CLI') or die;

/**
 * Class Cols
 *
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @since       3.2
 */
class Cols extends All
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected $name = 'cols';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Track table columns.';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'cols <cmd><command></cmd> <option>[option]</option>';

	protected $status = 'cols';

	/**
	 * Configure command information.
	 *
	 * @return void
	 */
	public function configure()
	{
		parent::configure();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		return parent::doExecute();
	}
}
