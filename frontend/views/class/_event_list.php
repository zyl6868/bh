<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/31
 * Time: 15:18
 */
use common\models\pos\SeClassEvent;
use frontend\components\helper\ViewHelper;

?>

          <?php
/*        @var SeClassEvent[]   $eventResult  */
          if(empty($eventResult)){
              ViewHelper::emptyViewByPage($pages);
          }else{
          foreach($eventResult as $v){?>
              <li>
                  <a class="timeLine_year"><?php echo date('Y',$v->time)?></a>
                  <dl>
                      <dt><?php echo date('m',$v->time)?>月</dt>
                      <dd>
                          <em><?php echo date('d',$v->time)?>日<br><b>13:21</b></em><i></i>
                          <span class="arrow_l"></span>
                          <div class="eventName"  eventID="<?=$v->eventID?>"><?php echo $v->eventName?></div>
                          <div class="toolBar hide"><a class="memorabilia_edit" href="javascript:;"></a><a href="javascript:;" class="memorabilia_del"></a></div>
                      </dd>
                  </dl>
              </li>
          <?php } }?>


<?php if(!empty($eventResult)){
    if ($pages->getPageCount() > $pages->getPage() + 1) {
    ?>
<a class="time_addMore" href="javascript:;" onclick="return  getEvent(<?php echo $classID ?>,<?php echo $pages->getPage() + 2; ?>);">点击查看更多 <i></i></a>
        <script>
            if(typeof(require)!="undefined") {
                require(['app/classes/classes_memorabilia'], function (classes_memorabilia) {
                    classes_memorabilia.yearHide();
                });
            }

            var getEvent = function (classID, page) {
                $.get('<?php echo url( 'class/get-event-page') ?>', {'classID': classID, 'page': page}, function (data) {
                    $('.time_addMore').replaceWith(data);
                });
            }
        </script>
<?php } }?>