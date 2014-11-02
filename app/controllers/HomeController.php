<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showHome');
	|
	*/

	public function showHome()
	{
		$projects = DB::table('projects')->take(10)->get();
		$projects_count = DB::table('projects')->count();

		$categories = $projects;

		$data = array(
			'projects' => $projects,
			'projects_count' => $projects_count
		);
		return View::make('home.index', $data);
	}

	public function showAbout()
	{
		$about = Page::find(1);
		$data = array(
			'about' => $about
		);
		return View::make('home.about', $data);
	}

	public function showMap()
	{
		$projects = DB::table('projects')->take(10)->get();

		$categories = Category::geocoded();

		$data = array(
			'projects' => $projects,
			'categories' => $categories
		);
		return View::make('home.map', $data);
	}

	public function getSearch()
	{
		$q = Input::get('q');

		$projects_sql = Project::whereRaw(
			"MATCH(title, description, geo_address, status) AGAINST (? IN BOOLEAN MODE)", 
			array($q)
		);
		$projects_count = $projects_sql->count();
		$projects = $projects_sql->take(10)->get();

		$data = array(
			'projects' => $projects,
			'projects_count' => $projects_count
		);
		return View::make('home.search', $data);
	}

}
