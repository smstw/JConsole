<?php
/**
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Command\Sqlsync\Import;

use JConsole\Command\JCommand;

defined('JPATH_CLI') or die;

/**
 * Class Import
 *
 * @package     Joomla.Cli
 * @subpackage  JConsole
 *
 * @since       3.2
 */
class Import extends JCommand
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
	protected $name = 'import';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Import a sql file.';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'import <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Configure command information.
	 *
	 * @return void
	 */
	public function configure()
	{
		// $this->addArgument();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		jimport('joomla.filesystem.folder');

		$db = \JFactory::getDbo();

		$list = \JFolder::files(JPATH_CLI . '/jconsole/resource/sql/export', '.', false, true);

		rsort($list);

		$file = array_shift($list);

		$this->out()->out("The newest sql export is: {$file}");

		$this->out('Importing...');

		$sql = file_get_contents($file);

		$sql = trim($sql);

		$queries = $db->splitSql($sql);

		foreach ($queries as $query)
		{
			$db->setQuery($query)->execute();
		}

		$this->out(sprintf("Import success. %s queries executed.", count($queries)));
	}
}