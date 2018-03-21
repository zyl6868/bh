<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/29
 * Time: 11:02
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;

?>
<script>
	$(function(){

        //预览课件
        $(document).on('click',"#previewMaterial",function () {
            var _this = $(this);
            var fileId = _this.attr("fileId");

            $.get('/ajax/preview-material',{fileId:fileId},function (result) {

                if(result.success == false){

                    if(result.code == 401 ){
                        dialogBox({
                            title:'预览课件',
                            content:'<p class="tc">'+result.message+'</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                            TrueBtn:{
                                name:'知道了'
                            }
                        });
                    }else{
                        popBox.errorBox(result.message);
                    }

                }else{
                    window.open(result.data);
                }

            });

        });


		$('.file_list li').hover(
			function(){
				$(this).children('.mask_link').show();
			},
			function(){
				$(this).children('.mask_link').hide();
			}
		);
		$('.addfavLink').bind('click',function () {
			var $_this = $(this);
			var id = $_this.attr('collectID');
			var type = $_this.attr('typeId');
			var action = $_this.attr('action');
			$.post("<?php echo url('teacher/default/add-material')?>", {id: id,type:type,action:action}, function (data) {
				if (data.success) {
					popBox.successBox(data.message);
					if (action==1){
						$_this.attr('action',0).text('取消收藏');
						$_this.addClass('favLink');
					}
					else {
						$_this.attr('action',1).text('收藏');
						$_this.removeClass('favLink');
					}
				} else {
					popBox.errorBox(data.message);
				}
			});
		});
		//取消收藏
		$('.delfavLink').bind('click',function(){
			var $_this = $(this);
			var id = $_this.attr('collectID');
			var type = $_this.attr('typeId');
			$.post("<?php echo url('/ajax/cancel-collect')?>",{id: id,type:type},function(data){
				if (data.success) {
					popBox.successBox(data.message);
					location.reload();
				} else {
					popBox.errorBox(data.message);
				}
			});
		});
$('#count').html('<?=$pages->totalCount; ?>')
	})
</script>

<div id="file_list">
<ul class="file_list clearfix">
	<?php if(empty($result)){
	  ViewHelper::emptyView();
	}else{
	foreach ($result as $val) :
		echo $this->render('_teacher_file_list_li',array('val'=>$val, 'listType'=>$listType , 'type'=>$val->matType, 'teacherId'=>$teacherId));
	endforeach;
	}?>
</ul>
	<?php
	 echo CLinkPagerExt::widget( array(
			'pagination' => $pages,
			'updateId' => '#file_list',
			'maxButtonCount' => 10
		)
	);
	?>
	</div>