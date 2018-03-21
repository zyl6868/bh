<?php
/**
 *
*/
namespace mithun\process\components;

use Yii;
use Arara\Process\Process;
use Arara\Process\Action\Action;


/**
 * ProcessTrait
 *
 * @author Mithun Mandal <mithun12000@gmail.com>
 */
trait ProcessTrait{
	/**
	 * 
	 * @var Process
	 */
	public $process;
	
	/**
	 * Process Wait 
	 */
    public function wait(){
    	$this->process->wait();
    }
    
    /**
     * Process Kill
     */
    public function kill(){
    	$this->process->kill();
    }
    
    /**
     * Process Terminate
     */
    public function terminate(){
    	$this->process->terminate();
    }
    
    /**
     * Process Start
     */
    public function start(){
    	$this->process->start();
    }
    
    /**
     * process is running or not
     * @return boolean
     */
    public function isRunning(){
    	return $this->process->isRunning();
    }
}