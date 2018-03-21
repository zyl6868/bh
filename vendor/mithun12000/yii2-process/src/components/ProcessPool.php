<?php
/**
 * 
 */
namespace mithun\process\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Arara\Process\Action\Action;
use Arara\Process\Action\Callback;
use Arara\Process\Pool;


/**
 * Process
 *
 * @author Mithun Mandal <mithun12000@gmail.com>
 */
class ProcessPool extends Component
{
	/**
	 * using ProcessTrait
	 */
	use ProcessTrait;
	
	/**
	 * Using Process Control Trait
	 */
	use ProcessControlTrait;
	
	/**
	 * Create a New Pool
	 * @param integer $processLimit
	 * @param boolean $autoStart
	 */
	public function create($processLimit, $autoStart = false){
		$this->process = new Pool($processLimit, $autoStart);
	}
	
	/**
	 * process count in a pool
	 * @return integer
	 */
	public function count(){
		return $this->process->count();
	}
	
	/**
	 * Attach Process to this Pool
	 * @param Process $action
	 */
	public function attach(Process $action){
		$this->process->attach($action->process);
	}
	
	/**
	 * Attach Process to this Pool
	 * @param Process $action
	 */
	public function detach(Process $action){
		$this->process->detach($action->process);
	}
}