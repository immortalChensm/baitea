<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"./template/mobile/mobile1/goods\ajaxComment.html";i:1517208521;}*/ ?>
<?php if($count > 0): ?>
  <div class="assess-flat " id="comList">
     <?php if(is_array($commentlist) || $commentlist instanceof \think\Collection || $commentlist instanceof \think\Paginator): if( count($commentlist)==0 ) : echo "" ;else: foreach($commentlist as $k=>$v): ?>
            <span class="assess-wrapper"  >
                <div class="assess-top">
                    <span class="user-portrait">
                        <img src="<?php echo (isset($v['head_pic']) && ($v['head_pic'] !== '')?$v['head_pic']:'__STATIC__/images/user68.jpg'); ?>">
                    </span>
                    <span class="user-name">
                        <?php if($v['is_anonymous'] == 0): ?>
                            匿名用户
                            <?php else: ?>
                            <?php echo $v['nickname']; endif; ?>
                    </span>
                    <!--<span class="vip-icon vip-copper-icon"></span>-->
                    <span class="assess-date"><?php echo date('Y-m-d H:i',$v['add_time']); ?></span>
                </div>
                <div class="assess-bottom">
                    <span class="comment-item-star">
                        <span class="real-star comment-stars-width<?php echo floor($v['goods_rank']); ?>"></span>
                    </span>
                    <p class="assess-content"><?php echo htmlspecialchars_decode($v['content']); ?></p>
                    <div class="product-img-module">
                        <a class="J_ping">
                            <ul class="jd-slider-container gallery">
                                <?php if(is_array($v['img']) || $v['img'] instanceof \think\Collection || $v['img'] instanceof \think\Paginator): if( count($v['img'])==0 ) : echo "" ;else: foreach($v['img'] as $key=>$v2): ?>
                                    <li class="jd-slider-item product-imgs-li">
                                        <a href="<?php echo $v2; ?>"><img src="<?php echo $v2; ?>" width="100px" height="100px"></a>
                                        <!--<img src="<?php echo $v2; ?>" width="100px" heigth="100px">-->
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </a>
                    </div>
                    <p class="pay-date">购买日期：<?php echo date("Y-m-d H:i:s",$v['pay_time']); ?></p>
                    <p class="product-type"><?php echo htmlspecialchars_decode($v['spec_key_name']); ?></p>
                    <!--商家回复-s-->
                    <?php if(is_array($replyList) || $replyList instanceof \think\Collection || $replyList instanceof \think\Paginator): if( count($replyList)==0 ) : echo "" ;else: foreach($replyList as $key=>$reply): if($reply['parent_id']  == $v['comment_id']): ?>
                            <p class="pay-date"><?php echo (isset($reply['username']) && ($reply['username'] !== '')?$reply['username']:'商家'); ?>回复：<?php echo $reply['content']; ?></p>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    <!--商家回复-e-->
                </div>
            </span>
             <div class="assess-btns-box">
                 <div class="assess-btns">
                     <a class="assess-like-btn" id="<?php echo $v[comment_id]; ?>" data-comment-id="<?php echo $v['comment_id']; ?>" onclick="zan(this);">
                         <i class="assess-btns-icon btn-like-icon like-grey <?php if(in_array($user_id,explode(',',$v['zan_userid']))): ?>like-red<?php endif; ?>"></i>
                         <span class="assess-btns-num" id="span_zan_<?php echo $v['comment_id']; ?>"><?php echo (isset($v['zan_num']) && ($v['zan_num'] !== '')?$v['zan_num']:0); ?></span>
                         <i class="like">+1</i>
                     </a>
                     <a href="<?php echo U('Mobile/Order/comment_info',['comment_id'=>$v['comment_id']]); ?>" class="assess-reply-btn" <?php if($v['reply_num'] > 0): ?>href="<?php echo U('Mobile/Goods/reply',array('comment_id'=>$v['comment_id'])); ?>"<?php endif; ?>>
                         <i class="no-assess-btns-icon btn-reply-icon"></i>
                         <span class="assess-btns-num" id="comment_id<?php echo $v[comment_id]; ?>"><?php echo $v['reply_num']; ?></span>
                     </a>
                 </div>
             </div>
     <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
<?php else: ?>
     <script>
         $('.getmore').hide();
     </script>
    <!--没有内容时-s-->
    <div class="comment_con p">
       <div class="score enkecor">此商品暂无评论</div>
    </div>
    <!--没有内容时-e-->
<?php endif; ?>
<link href="__STATIC__/css/photoswipe.css" rel="stylesheet" type="text/css">
<script src="__STATIC__/js/klass.min.js"></script>
<script src="__STATIC__/js/photoswipe.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var gallery_a = $(".gallery a");
        if(gallery_a.length > 0){
            $(".assess-wrapper .gallery a").photoSwipe({
                enableMouseWheel: false,
                enableKeyboard: false,
                allowUserZoom: false,
                loop:false
            });
        }
    });

     var page = <?php echo \think\Request::instance()->param('p'); ?>;
     function ajax_sourch_submit() {
         page += 1;
         $.ajax({
             type: "GET",
             url: "<?php echo U('Mobile/Goods/ajaxComment',array('goods_id'=>\think\Request::instance()->param('goods_id'),'commentType'=>$commentType),''); ?>"+"/p/" + page,
             success: function (data) {
                 $('.getmore').hide();
                 if ($.trim(data) != ''){
                     $("#comList").append(data);
                 }
             }
         });
     }
     function ajax_sourch_submit_hide(){
         $('.getmore').hide();
     }

     //点赞
     function hde(){
         setTimeout(function(){
             $('.alert').hide();
         },1200)
     }
 </script>