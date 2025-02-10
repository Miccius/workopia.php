<?php

namespace App\Controllers;

use Framework\Database;

class HomeController

{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this->db = new Database($config);

        //die('HomeController');
    }


    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings Order By created_at DESC LIMIT 6')->fetchAll();

        //inspect($listings);
        
        //loadView('home');
        
        loadView('home', ['listings' => $listings, 'name' => 'Mitch']);
    }

    
}