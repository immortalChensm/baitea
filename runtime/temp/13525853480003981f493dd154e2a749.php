<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"./template/mobile/mobile1/index\ajaxGetMore.html";i:1517208521;}*/ ?>
<?php if(is_array($favourite_goods) || $favourite_goods instanceof \think\Collection || $favourite_goods instanceof \think\Paginator): if( count($favourite_goods)==0 ) : echo "" ;else: foreach($favourite_goods as $key=>$v): ?>  
        <div class="goods-list">
                <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>" title="<?php echo $v['goods_name']; ?>">
                    <div class="goods-img" style="background-image: url(<?php echo goods_thum_images($v[goods_id],310,310); ?>)"></div>
                    <div class="goods-name"><?php echo $v[goods_name]; ?></div>
                    <div class="goods-money">￥<?php echo $v[shop_price]; ?></div>
                </a>
       </div>
<?php endforeach; endif; else: echo "" ;endif; ?>