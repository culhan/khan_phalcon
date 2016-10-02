<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

class RouteHelper{

	// collection variable
	protected $collection;

	protected $routeMatched;

	protected $urlName;

	public function __construct()
	{
		$this->collection = new MicroCollection;
	}

	/**
	 * [loadRoute for 4 concept controller function]
	 * Generate Route GET,SHOW,SAVE,DELETE
	 * @param  [string] $className [class name]
	 * @param  [string] $name  [route name]
	 * @return [object]        [phalcon collection]
	 */
	public function loadRoute( $className, $name, $app )
	{

		if( $this->HandledRoute( $app, $name) )
		{			
			return $app;
		}		

		$this->setHadlerRoute( $className );

		$this->setPrefixRoute( $name );

		if( $app->request->getMethod() == 'GET' && !isset($this->urlName['3']) )
		{
			// get all
			$this->collection->get('/', 'index');
		}

		if( $app->request->getMethod() == 'GET' && isset($this->urlName['3']) )
		{			
			// show
			$this->collection->get('/{id}', 'show');
		}

		if( $app->request->getMethod() == 'POST' )
		{
			// save
			$this->collection->post('/', 'store');
		}

		if( $app->request->getMethod() == 'DELETE' )
		{
			// delete
			$this->collection->delete('/{id}', 'destroy');
		}

		return $app->mount( $this->collection );

	}

	/**
	 * [setPrefixRoute]
	 * @param [type] $name [prefix name]
	 */
	public function setPrefixRoute( $name )
	{		
		$this->collection->setPrefix( '/api/'.$name );
	}

	/**
	 * [setHadlerRoute]
	 * @param [type] $className [controller name]
	 */
	public function setHadlerRoute( $className )
	{
		$this->collection->setHandler( $className, true );
	}

	/**
	 * [load route for dynamic function dll]
	 * @param  [type] $className          [description]
	 * @param  [type] $name               [description]
	 * @param  [type] $method             [description]
	 * @param  string $param              [description]
	 * @param  [type] $functionController [description]
	 * @return [type]                     [description]
	 */
	public function loadRouteDynamic( $className, $name, $method, $param = '/', $functionController, $app )
	{

		if( $this->HandledRoute( $app, $name) )
		{
			return $app;
		}

		$this->setHadlerRoute( $className );

		$this->setPrefixRoute( $name );

		$this->collection->$method( $param, $functionController);

		return $app->mount( $this->collection );

	}
	
	/**
	 * handled descission to assign route
	 * @param Object $app app phalcon
	 * @param string $name route name
	 */
	public function HandledRoute( $app, $name )
	{
		$urlName = explode('/',$app->request->getURI());
		
		if (strpos($urlName[2], '?') !== false) 
		{		    
		    $urlName[2] = explode('?', $urlName[2])[0];
		}
		
		$this->urlName = $urlName;

		if( !empty($this->routeMatched) || $urlName[2] != $name)
		{						
			return true;
		}
		
		$this->routeMatched = $name;

		return false;
	}
}