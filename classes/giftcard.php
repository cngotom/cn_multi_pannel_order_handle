<?php

/**
 * @copyright (c) 2011 jooyea.cn
 * @file giftcard.php
 * @brief 礼卡相关的
 * @author guotao 
 * @date 2013-08-07
 * @version 1.0
 */

class Giftcard
{
            const SESSION_CARD_ID_KEY = 'gift_card_id';
            const SESSION_CARD_VOLUME_ID_KEY = 'gift_card_volume_id';
            const SESSION_CARD_GOODS_ID_KEY = 'gift_card_goods_id';
            
            const TABLE_NAME = 'gift_card';
           /**
            *判断是否已经使用礼卡登陆
            * @param null
            * @return bool 1 已经登录；0 未登录 
            */
            public  static function is_card_login()
            {
                $card_id = ISafe::get(self::SESSION_CARD_ID_KEY);
                return $card_id;
            }

    
          /**
           *  礼卡登陆
           *  @param $no 礼卡账号
           *  @param $password 礼卡密码
           *  @return $message   空 登陆成功  非空 错误信息
           */
           public static function card_login($no,$password)
           {
                    $message = '';
                    $obj_card =  new IModel(self::TABLE_NAME);
                    $encode_password = substr(sha1(IFilter::act($password,'text')), 0,64);
                    $card_info = $obj_card->getObj(" no = '$no' and password = '$encode_password'" );
                    if(empty($card_info))
                    {
                        $message = '礼品账号密码不正确';
                    }
                    else if( $card_info['is_used'] != 0 )
                    {
                        $message = '该礼品卡已经兑换';
                    }
                    else
                    {
                        $gift_card_id = $card_info['id'];
                        ISafe::set(self::SESSION_CARD_ID_KEY,$gift_card_id );
                        ISafe::set(self::SESSION_CARD_VOLUME_ID_KEY,$card_info['volume_id'] );
                    }
                    return $message;
           }
    
           
           /*
            * 获取已登陆登陆礼卡信息
            * @param null
            * @return array 登陆礼卡信息
            */
            public static function get_login_card_info()
            {
                if(self::is_card_login())
                {
                    
                    $volume_id = ISafe::get(self::SESSION_CARD_VOLUME_ID_KEY);
                    $card_id = ISafe::get(self::SESSION_CARD_ID_KEY);
                    $goods_id = ISafe::get(self::SESSION_CARD_GOODS_ID_KEY);
                    return array(
                        'volume_id' => $volume_id,
                        'card_id' => $card_id,
                        'goods_id' => $goods_id
                    );
                }
                else
                    return array();
            }
              /*
            * 获取已登的礼卡是否已经使用
            * @param null
            * @return array 登陆礼卡信息
            */
            public static function is_card_used()
            {
                if(self::is_card_login())
                {
                      $card_id = ISafe::get(self::SESSION_CARD_ID_KEY);
                      $obj_gift_card = new IModel(self::TABLE_NAME);   
                      $card_info = $obj_gift_card->getObj('id = '.$card_id );
                      
                      return $card_info['is_used'] == 1;
                }
                else{
                    throw new IException('is_card_login should be called first');
                }
                         
            }
            
            /*
             * 获取订单对应礼卡的标题 
             */
            public static function get_card_title_by_order($order_id)
            {
                    $volumes_info = self::get_card_info_by_order($order_id);
                    if(!empty($volumes_info))
                        return $volumes_info['title'];
                    else
                        return "";
            }
            
              /*
             * 获取订单对应礼卡的信息 
             */
            public static function get_card_info_by_order($order_id)
            {
                    $volumes_goods = new IQuery('gift_card as g');
                    $volumes_goods->join ='inner  join order as o on g.order_id = o.id  left join volumes as v on v.id = g.volume_id';
                    $volumes_goods->where = ' o.id =  '.$order_id;
                    $volumes_goods->fields = 'v.title as title, g.no as no,g.use_time as use_time,g.message as message';
                    $volumes_info = $volumes_goods->find();
                    if(!empty($volumes_info))
                        return $volumes_info[0];
                    else
                        return array();
            }
            
            /*使用礼卡
             *  
             *  
             */
            public static function do_use_card($order_id)
            {
                if(!self::is_card_login())
                {
                      throw new IException('is_card_login should be called first');
                }
                else if(self::is_card_used())
                {
                      throw new IException('is_card_used should be called first');
                }
                else
                {
                    $user_id = ISafe::get('user_id');
                    $card_id = ISafe::get(self::SESSION_CARD_ID_KEY);
                    $user_id = ($user_id)?$user_id:0;
            
                    if($user_id >0 )
                        ; //插入用户记录表
                    $goods_id = ISafe::get(self::SESSION_CARD_GOODS_ID_KEY);
                    //修改礼卡状态
                    $obj_gift_card = new IModel('gift_card');   
                    $giftCardData = array(
                        'use_time' => time(),
                        'message' => '兑换产品ID'.$goods_id.' order_id '.$order_id ,
                        'order_id' =>$order_id,
                        'is_used' =>1 ,
                    );
                    $obj_gift_card->setData($giftCardData);
                    $obj_gift_card->update('id = '.$card_id);  
                }
            }
           
            
             /*
            * 销毁safe变量
            * @param null
            * @return null
            */       
            public static function destroy()
            {
                   ISafe::clear(self::SESSION_CARD_VOLUME_ID_KEY);
                   ISafe::clear(self::SESSION_CARD_ID_KEY);
                   ISafe::clear(self::SESSION_CARD_GOODS_ID_KEY);
            }
}
?>
