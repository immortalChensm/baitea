<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:51:"./template/mobile/mobile1/index\ajaxStreetList.html";i:1517208521;}*/ ?>
<?php if(is_array($store_list) || $store_list instanceof \think\Collection || $store_list instanceof \think\Paginator): $i = 0; $__LIST__ = $store_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?>
   <div class="dis-box p">
            <div class="g-s-i-img fl">
            	<a href="<?php echo U('Store/index',array('store_id'=>$store[store_id])); ?>"><img src="<?php echo $store['store_avatar']; ?>"></a>
            </div>
            <div class="g-s-i-title fl">
                <h3 class="ellipsis-one"><?php echo $store['store_name']; ?></h3>
                <p class="t-remark m-top04">已经有 <span class="num1 store_collect_<?php echo $store[store_id]; ?>" ><?php echo $store['store_collect']; ?></span>人关注</p>
                <!--<p class="t-remark"><span class="red">距离1500米</span></p>-->
            </div>
            <div class="g-s-info-add fr" id="store_<?php echo $store['store_id']; ?>">
                <?php if(empty($store['add_time'])): ?>
                    <a href="javascript:void(0)" onclick="favoriteStore(<?php echo $store['store_id']; ?>)" class="fgaze1">关注</a>
                <?php else: ?>
                    <a href="javascript:void(0)" class="collect">已关注</a>
                <?php endif; ?>
            </div>
            <div class="comment">
            	<ul>
            		<li>
            			<span>宝贝描述</span>
            			<span class="red"><?php if($store['store_desccredit'] == 0): ?>5.0<?php else: ?><?php echo number_format($store['store_desccredit'],1); endif; ?>分</span>
            			<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>低<?php endif; $_RANGE_VAR_=explode(',',"2,3.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>中<?php endif; $_RANGE_VAR_=explode(',',"4,5");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>高<?php endif; ?>
            			</em>
            		</li>
            		<li>
            			<span>卖家服务</span>
            			<span class="red"><?php if($store['store_servicecredit'] == 0): ?>5.0<?php else: ?><?php echo number_format($store['store_servicecredit'],1); endif; ?>分</span>
						<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>低<?php endif; $_RANGE_VAR_=explode(',',"2,3.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>中<?php endif; $_RANGE_VAR_=explode(',',"4,5");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
            		</li>
            		<li>
            			<span>物流速度</span>
            			<span><?php if($store['store_deliverycredit'] == 0): ?>5.0<?php else: ?><?php echo number_format($store['store_deliverycredit'],1); endif; ?>分</span>
            			<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>低<?php endif; $_RANGE_VAR_=explode(',',"2,3.99");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>中<?php endif; $_RANGE_VAR_=explode(',',"4,5");if($store['store_desccredit']>= $_RANGE_VAR_[0] && $store['store_desccredit']<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
            		</li>
            	</ul>
            </div>
            <?php if(!(empty($store['goods_array']['goods_list']) || (($store['goods_array']['goods_list'] instanceof \think\Collection || $store['goods_array']['goods_list'] instanceof \think\Paginator ) && $store['goods_array']['goods_list']->isEmpty()))): ?>
            <div class="baokaun">
				<div class="shop">
					<ul>
					<?php if(is_array($store['goods_array']['goods_list']) || $store['goods_array']['goods_list'] instanceof \think\Collection || $store['goods_array']['goods_list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $store['goods_array']['goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?>
						<li>
							<a href="<?php echo U('Goods/goodsInfo',array('id'=>$goods['goods_id'])); ?>">
								<div class="similer-product">
									<img src="<?php echo goods_thum_images($goods['goods_id'],150,150); ?>">
									<span class="similar-product-text"><?php echo $goods['goods_name']; ?></span>
									<span class="similar-product-price">
										¥<span class="big-price"><?php echo $goods['shop_price']; ?></span>
										<span class="small-price"></span>
									</span>
								</div>
							</a>
						</li>
				     <?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
        </div>
<?php endforeach; endif; else: echo "" ;endif; ?>