<?php
/**
 * 
 */
namespace mithun\process\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use Arara\Process\Action\Action;
use Arara\Process\Action\Callback;
use Arara\Process\Control;
use Arara\Process\Context;
use Arara\Process\Child;


/**
 * Process
 *
 * @author Mithun Mandal <mithun12000@gmail.com>
 */
class Process extends Component
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
	 * Create a process
	 * @param Action $action
	 * @param number $timeout
	 * @param ProcessPool $pcontrol
	 */
	public function create(Action $action, $timeout = 0, ProcessPool $pcontrol = null){
		if($pcontrol && $pcontrol->control instanceof Control){
			$this->control = $pcontrol->control;
		}else{
			$this->createControl();
		}
		$this->process = new Child($action, $this->control, $timeout);
	}
	
	/**
	 * Return the process id (PID).
	 *
	 * @return int
	 */
	public function getId()
	{	
		return $this->process->getId();
	}
	
	/**
	 * Return TRUE if there is a defined id or FALSE if not.
	 *
	 * @return bool
	 */
	public function hasId()
	{
		return $this->process->hasId();
	}
	
	/**
	 * Return the process status.
	 *
	 * @return Status
	 */
	public function getStatus()
	{
		return $this->process->getStatus();
	}
}