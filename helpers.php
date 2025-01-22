<?php 


/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */

 function basePath($path = '') 
 {
   return __DIR__ . '/' . $path;
 }
/**
  * Load a vew
  *@param string $name
  *@return void

  */

  function loadView($name, $data = []) 
  {
    $viewPath = basePath("App/views/{$name}.view.php");

    //inspectAndDie($viewPath);

    if(file_exists($viewPath)) {
      extract($data);
      require $viewPath;
  } else {
    echo "View '{$name} not found!'";
  }

  }

 /**
  * Load a vew
  *@param string $name
  *@return void

  */

  function loadPartial($name) 
  {
      $path = basePath("App/views/partials/{$name}.php");
      if (file_exists($path)) {
          require $path;
      } else {
          echo "Partial '{$name}' not found at {$path}";
      }
  }
  

  function inspect($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}

/**
 * Inspect a value(s) and die
 * 
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
  echo '<pre>';
  die(var_dump($value));
  echo '</pre>';
}


function formatSalary($salary) {
  return '$' . number_format(floatval($salary));
}