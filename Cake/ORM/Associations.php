<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace Cake\ORM;

use Cake\ORM\Association;
use Cake\ORM\Entity;
use Cake\ORM\Table;

/**
 * A container/collection for association classes.
 *
 * Contains methods for managing associations, and
 * ordering operations around saving and deleting.
 */
class Associations {

/**
 * Stored associations
 *
 * @var array
 */
	protected $_items = [];

/**
 * Add an association to the collection
 *
 * @param string $alias The association alias
 * @param Association The association to add.
 * @return void
 */
	public function add($alias, Association $association) {
		return $this->_items[strtolower($alias)] = $association;
	}

/**
 * Fetch an attached association by name.
 *
 * @param string $alias The association alias to get.
 * @return Association|null Either the association or null.
 */
	public function get($alias) {
		$alias = strtolower($alias);
		if (isset($this->_items[$alias])) {
			return $this->_items[$alias];
		}
		return null;
	}

/**
 * Check for an attached association by name.
 *
 * @param string $alias The association alias to get.
 * @return boolean Whether or not the association exists.
 */
	public function has($alias) {
		return isset($this->_items[strtolower($alias)]);
	}

/**
 * Get the names of all the associations in the collection.
 *
 * @return array
 */
	public function keys() {
		return array_keys($this->_items);
	}

/**
 * Get an array of associations matching a specific type.
 *
 * @return array
 */
	public function type($class) {
		$out = array_filter($this->_items, function ($assoc) use ($class) {
			return strpos(get_class($assoc), $class) !== false;
		});
		return array_values($out);
	}

/**
 * Drop/remove an association.
 *
 * Once removed the association will not longer be reachable
 *
 * @param string The alias name.
 * @return void
 */
	public function remove($alias) {
		unset($this->_items[strtolower($alias)]);
	}

/**
 * Save all the associations that are parents of the given entity.
 *
 * Parent associations include any association where the given table
 * is the owning side.
 *
 * @param Table $table The table entity is for.
 * @param Entity $entity The entity to save associated data for.
 * @param array $associations The list of associations to save parents from.
 *   associations not in this list will not be saved.
 * @param array $options The options for the save operation.
 * @return boolean Success
 */
	public function saveParents(Table $table, Entity $entity, $associations, $options = []) {
		if (empty($associations)) {
			return true;
		}
		return $this->_saveAssociations($table, $entity, $associations, $options, false);
	}

/**
 * Save all the associations that are children of the given entity.
 *
 * Child associations include any association where the given table
 * is not the owning side.
 *
 * @param Table $table The table entity is for.
 * @param Entity $entity The entity to save associated data for.
 * @param Entity $entity The entity to save associated data for.
 * @param array $associations The list of associations to save children from.
 *   associations not in this list will not be saved.
 * @param array $options The options for the save operation.
 * @return boolean Success
 */
	public function saveChildren(Table $table, Entity $entity, $associations, $options) {
		if (empty($associations)) {
			return true;
		}
		return $this->_saveAssociations($table, $entity, $associations, $options, true);
	}

/**
 * Helper method for saving an association's data.
 *
 * @param Table $table The table the save is currently operating on
 * @param Entity $entity The entity to save
 * @param array $associations Array of associations to save.
 * @param array $options Original options
 * @param boolean $owningSide Compared with association classes'
 *   isOwningSide method.
 * @return boolean Success
 * @throws new \InvalidArgumentException When an unknown alias is used.
 */
	protected function _saveAssociations($table, $entity, $associations, $options, $owningSide) {
		unset($options['associated']);
		foreach ($associations as $alias => $nested) {
			if (is_int($alias)) {
				$alias = $nested;
				$nested = [];
			}
			$relation = $this->get($alias);
			if (!$relation) {
				$msg = __d(
					'cake_dev',
					'Cannot save %s, it is not associated to %s',
					$alias,
					$table->alias()
				);
				throw new \InvalidArgumentException($msg);
			}
			if ($relation->isOwningSide($table) !== $owningSide) {
				continue;
			}
			if (!$this->_save($relation, $entity, $nested, $options)) {
				return false;
			}
		}
		return true;
	}

/**
 * Helper method for saving an association's data.
 *
 * @param Association $association The association object to save with.
 * @param Entity $entity The entity to save
 * @param array $nested Options for deeper associations
 * @param array $options Original options
 * @return boolean Success
 */
	protected function _save($association, $entity, $nested, $options) {
		if (!$entity->dirty($association->property())) {
			return true;
		}
		if (!empty($nested)) {
			$options = (array)$nested + $options;
		}
		return (bool)$association->save($entity, $options);
	}

/**
 * Cascade a delete across the various associations.
 *
 * @param Entity $entity The entity to delete associations for.
 * @param array $options The options used in the delete operation.
 * @return void
 */
	public function cascadeDelete(Entity $entity, $options) {
		foreach ($this->_items as $assoc) {
			$assoc->cascadeDelete($entity, $options);
		}
	}

}