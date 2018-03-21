<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-14
 * Time: 下午3:45
 */
namespace frontend\components\helper;

use stdClass;

class KnowTreeHelper {


    public  static  function makeTree($kModelList, $kid, $type, $complexity,$route)
    {
        $kModel = [];
        $callback =
            function ($item) use ($kid,$type,$complexity,$route) {
                $k = new  stdClass();
                $k->id = $item->id;
                $k->pId = $item->pId;
                $k->name = $item->name;
                $k->url =url($route,['department' => $item->schoolLevel, 'subjectid' => $item->subject, 'kid' => $item->id,'type'=>$type,'complexity'=>$complexity]);
                $k->target = '_self';
                if ($kid == $item->id) {
                    $k->font = ["color" => "red"];
                    $k->open = false;
                    $k->class = 'curSelectedNode';
                }
                return $k;
            };
        foreach ($kModelList as $item) {
            $kModel[] = $callback($item);
        }
        return $kModel;
    }

	//题目管理中  用于知识点选题 wgl
	public static function knowledgeMakeTree($kModelList, $kid, $type, $complexity, $n, $route)
	{
		$kModel = [];
		$callback =
			function ($item) use ($kid,$type,$complexity, $n,$route) {
				$k = new  stdClass();
				$k->id = $item->id;
				$k->pId = $item->pId;
				$k->name = $item->name;
				$k->url =url($route,['department' => $item->schoolLevel, 'subjectid' => $item->subject, 'kid' => $item->id,'type'=>$type, 'complexity'=>$complexity, 'n'=>$n]);
				$k->target = '_self';
				if ($kid == $item->id) {
					$k->font = ["color" => "red"];
					$k->open = false;
					$k->class = 'curSelectedNode';
				}
				return $k;
			};
		foreach ($kModelList as $item) {
			$kModel[] = $callback($item);
		}
		return $kModel;
	}

	//题目管理中  用于章节选题 wgl
	public static function chapterMakeTree($kModelList, $department, $subjectid, $chapId, $type, $complexity,$n,$version, $route)
	{
		$kModel = [];
		$callback =
			function ($item) use ($department,$subjectid,$chapId,$type,$complexity, $n,$version, $route) {
				$k = new  stdClass();
				$k->id = $item->cid;
				$k->pId = $item->pid;
				$k->name = $item->chaptername;
				$k->url =url($route,['department' => $department, 'subjectId' => $subjectid, 'chapterId' => $item->cid,'type'=>$type,'complexity'=>$complexity,'n'=>$n, 'version'=>$version]);
				$k->target = '_self';
				if ($chapId == $item->cid) {
					$k->font = ["color" => "red"];
					$k->open = false;
					$k->class = 'curSelectedNode';
				}
				return $k;
			};
		foreach ($kModelList as $item) {

			$kModel[] = $callback($item);
		}
		return $kModel;
	}
} 