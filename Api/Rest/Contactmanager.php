<?php
namespace FreePBX\modules\Contactmanager\Api\Rest;
use FreePBX\modules\Api\Rest\Base;
class Contactmanager extends Base {
	protected $module = 'contactmanager';
	public function setupRoutes($app) {

		/**
		 * @verb GET
		 * @returns - contactmanager groups
		 * @uri /contactmanager/groups
		 */
		$freepbx = $this->freepbx;
		$app->get('/groups', function ($request, $response, $args) use($freepbx) {
			$groups = $freepbx->Contactmanager->getGroups();
			$response->getBody()->write(json_encode($groups));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		 * @verb GET
		 * @returns - contactmanager groups
		 * @uri /contactmanager/groups/:id
		 */
		$app->get('/groups/{id}', function ($request, $response, $args) use($freepbx) {
			$groups = $freepbx->Contactmanager->getGroupsbyOwner($args['id']);
			$response->getBody()->write(json_encode($groups));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		 * @verb GET
		 * @returns - contactmanager group info
		 * @uri /contactmanager/groups/:id/:groupid
		 */
		$app->get('/groups/{id}/{groupid}', function ($request, $response, $args) use($freepbx) {
			$group = $freepbx->Contactmanager->getGroupByID($args['groupid']);
			if($group['owner'] !== -1 && $group['owner'] !== $args['id']) {
				$response->getBody()->write(json_encode(false));
				return $response->withHeader('Content-Type', 'application/json');
			}
			$response->getBody()->write(json_encode($group));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		 * @verb GET
		 * @returns - contactmanager entry info
		 * @uri /contactmanager/groups/:id/:groupid/:entryid
		 */
		$app->get('/groups/{id}/{groupid}/entries', function ($request, $response, $args) use($freepbx) {
			$group = $freepbx->Contactmanager->getGroupByID($args['groupid']);
			if($group['owner'] !== -1 && $group['owner'] !== $args['id']) {
				$response->getBody()->write(json_encode(false));
				return $response->withHeader('Content-Type', 'application/json');
			}
			$list = $freepbx->Contactmanager->getEntriesByGroupID($args['groupid']);
			$response->getBody()->write(json_encode($list));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		 * @verb GET
		 * @returns - contactmanager entries
		 * @uri /contactmanager/entries/:id
		 */
		$app->get('/entries/{id}', function ($request, $response, $args) use($freepbx) {
			$entry = $freepbx->Contactmanager->getEntryByID($args['id']);
			$response->getBody()->write(json_encode($entry));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());
	}
}
