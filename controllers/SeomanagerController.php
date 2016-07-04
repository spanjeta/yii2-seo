<?php

namespace spanjeta\modules\seomanager\controllers;

use yii\web\Controller;
use spanjeta\modules\seomanager\models\search\SeomanagerSearch;
use spanjeta\modules\seomanager\models\Seomanager;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;

/**
 *
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@gmail.com>
 *
 * @since 1.0
 *        SeoController implements the CRUD actions for Seo model.
 */
class SeomanagerController extends Controller {
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	public function actionRoute() {
		Yii::$app->response->format = 'json';
		$controllerlist = [ ];
		$name = Yii::getAlias ( '@app' );
		
		$pos = strrpos ( $_GET ['title'], '\\' );
		$class = substr ( substr ( $_GET ['title'], $pos + 0 ), 0, - 10 );
		
		$nameController = Inflector::camel2id ( $class );
		
		if ($views = opendir ( $name . '/views/' . $nameController )) {
			while ( false !== ($file = readdir ( $views )) ) {
				$viewlist [] = $file;
			}
			closedir ( $views );
		}
		
		$fulllist = [ ];
		
		$handle = fopen ( $name . '/controllers/' . $_GET ['title'] . ".php", "r" );
		if ($handle) {
			while ( ($line = fgets ( $handle )) !== false ) {
				if (preg_match ( '/public function action(.*?)\(/', $line, $display )) :
					if (strlen ( $display [1] ) > 2) :
						$actionname = Inflector::camel2id ( $display [1] );
						
						$nameController = Inflector::camel2id ( $class );
						$fulllist ['url'] [strtolower ( $nameController . '/' . $actionname )] [] = strtolower ( $nameController . '/' . $actionname );
					

                    endif;
				
                endif;
			}
		}
		fclose ( $handle );
		
		return $fulllist;
	}
	/**
	 * Lists all Seo models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new SeomanagerSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( 'index', [ 
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider 
		] );
	}
	
	/**
	 * Displays a single Seo model.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', [ 
				'model' => $this->findModel ( $id ) 
		] );
	}
	
	/**
	 * Creates a new Seo model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Seomanager ();
		
		if ($model->load ( Yii::$app->request->post () )) {
			
			$model->created = time ();
			
			$model->data = json_encode ( [ 
					'content' => $model->content,
					'position' => $model->position 
			] );
			
			if ($model->save ()) {
				return $this->redirect ( [ 
						'view',
						'id' => $model->id 
				] );
			}
		}
		
		return $this->render ( 'create', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Updates an existing Seo model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		$data = json_decode ( $model->data, true );
		
		$model->content = (isset ( $data ['content'] )) ? $data ['content'] : '';
		$model->position = (isset ( $data ['position'] )) ? $data ['position'] : '';
		
		if ($model->load ( Yii::$app->request->post () )) {
			
			$model->updated = time ();
			
			$model->data = json_encode ( [ 
					'content' => $model->content,
					'position' => $model->position 
			] );
			
			if ($model->save ()) {
				return $this->redirect ( [ 
						'view',
						'id' => $model->id 
				] );
			}
		} else {
			return $this->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing Seo model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Finds the Seo model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id        	
	 * @return Seo the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Seomanager::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	public function actionClearCache($id) {
		$model = Seomanager::findOne ( $id );
		
		if ($model !== null) {
			
			$key = 'seomanager.route' . $model->route;
			
			Yii::$app->cache->delete ( $key );
		}
		
		return $this->redirect ( [ 
				'update',
				'id' => $id 
		] );
	}
}
