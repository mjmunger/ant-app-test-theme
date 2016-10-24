<?php

namespace PHPAnt\TestTheme;

/**
 * App Name: Test Theme
 * App Description: This is a short, proof of concept app that shows the basics of creating theme apps for PHP-Ant.
 * App Version: 1.0
 * App Action: cli-load-grammar -> loadTestTheme @ 90
 * App Action: cli-init         -> declareMySelf  @ 50
 * App Action: cli-command      -> processCommand @ 50
 */

 /**
 * This app adds the Test Theme and commands into the CLI by adding in
 * the grammar for commands into an array, and returning it up the chain.
 *
 * @package      PHPAnt
 * @subpackage   TestTheme
 * @category     Themes
 * @author       Michael Munger <michael@highpoweredhelp.com>
 */ 


class TestTheme extends \PHPAnt\Core\AntApp implements \PHPAnt\Core\AppInterface  {

    /**
     * Instantiates an instance of the TestTheme class.
     * Example:
     *
     * <code>
     * $appTestTheme = new TestTheme();
     * </code>
     *
     * @return void
     * @author Michael Munger <michael@highpoweredhelp.com>
     **/

    function __construct() {
        $this->appName = 'Test Theme';
        $this->canReload = true;
        $this->path = __DIR__;
    }

    /**
     * Callback for the cli-load-grammar action, which adds commands specific to this plugin to the CLI grammar.
     * Example:
     *
     * @return array An array of CLI grammar that will be merged with the rest of the grammar. 
     * @author Michael Munger <michael@highpoweredhelp.com>
     **/

    function loadTestTheme() {
        $grammar = [];

        $this->loaded = true;
        
        $results['grammar'] = $grammar;
        $results['success'] = true;
        return $results;
    }

    //Uncomment this function and the following function to enable the autoloader for this plugin.
    function TestThemeAutoLoader() {
        //REGISTER THE AUTOLOADER! This has to be done first thing! 
        spl_autoload_register(array($this,'loadTestThemeClasses'));
        return ['success' => true];

    }

    public function loadTestThemeClasses($class) {
        $baseDir = $this->path;

        $candidate_files = array();

        //Try to grab it from the classes directory.
        $candidate_path = sprintf($baseDir.'/classes/%s.class.php',$class);
        array_push($candidate_files, $candidate_path);

        //Loop through all candidate files, and attempt to load them all in the correct order (FIFO)
        foreach($candidate_files as $dependency) {
            if($this->verbosity > 14) printf("Looking to load %s",$dependency) . PHP_EOL;

            if(file_exists($dependency)) {
                if(is_readable($dependency)) {

                    //Print debug info if verbosity is greater than 9
                    if($this->verbosity > 9) print "Including: " . $dependency . PHP_EOL;

                    //Include the file!
                    include($dependency);
                }
            }
        }
        return ['success' => true];
    }
    
    /**
     * Callback function that prints to the CLI during cli-init to show this plugin has loaded.
     * Example:
     *
     * @return array An associative array declaring the status / success of the operation.
     * @author Michael Munger <michael@highpoweredhelp.com>
     **/

    function declareMySelf() {
        if($this->verbosity > 4 && $this->loaded ) print("Test Theme app loaded.\n");

        return ['success' => true];
    }

    function processCommand($args) {
        $cmd = $args['command'];

        return ['success' => true];
    }


}