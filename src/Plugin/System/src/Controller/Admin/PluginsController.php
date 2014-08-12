<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since	 1.0.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 * @license	 http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace System\Controller\Admin;

use Cake\Error\NotFoundException;
use System\Controller\AppController;
use QuickApps\Core\Plugin;

/**
 * Controller for handling plugin tasks.
 *
 * Here is where can install new plugin or remove existing ones.
 */
class PluginsController extends AppController {

/**
 * Main action.
 *
 * @return void
 */
	public function index() {
		$plugins = Plugin::collection(true)
			->match(['isTheme' => false])
			->toArray();
		$this->set('plugins', $plugins);
		$this->Breadcrumb->push('/admin/system/plugins');
	}

/**
 * Handles plugin's specifics settings.
 *
 * @return void
 */
	public function settings($pluginName) {
		$plugin = Plugin::info($pluginName, true);
		$arrayContext = [
			'schema' => [],
			'defaults' => [],
			'errors' => [],
		];

		if (!$plugin['hasSettings'] || $plugin['isTheme']) {
			throw new NotFoundException(__d('system', 'The requested page was not found.'));
		}

		if (!empty($this->request->data)) {
			$this->loadModel('System.Plugins');
			$pluginEntity = $this->Plugins->get($pluginName);
			$pluginEntity->set('settings', $this->request->data);

			if ($this->Plugins->save($pluginEntity)) {
				$this->alert(__d('system', 'Plugin settings saved!'), 'success');
				$this->redirect($this->referer());
			} else {
				$this->alert(__d('system', 'Plugin settings could not be saved'), 'danger');
				$errors = $pluginEntity->errors();

				if (!empty($errors)) {
					foreach ($errors as $field => $message) {
						$arrayContext['errors'][$field] = $message;
					}
				}
			}
		} else {
			$this->request->data = $plugin['settings'];
		}

		$this->set('arrayContext', $arrayContext);
		$this->set('plugin', $plugin);
		$this->Breadcrumb->push('/admin/system/plugins');
		$this->Breadcrumb->push(__d('system', 'Settings for %s plugin', $plugin['name']), '#');
	}

}
