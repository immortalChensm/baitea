<?php
namespace app\common\logic;
use think\Db;
use think\Model;

class LiveLogic extends Model
{
    protected $table = "tp_live_audience";
    //add audience num
    public function add_audience($userid,$liveid)
    {
        if(!$this->where("userid",$userid)->where("liveid",$liveid)->value("liveid")){
            if($this->save(["userid"=>$userid,"liveid"=>$liveid,"add_time"=>time()])){
                return $this->id;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    
    public function decraudience($userid,$liveid)
    {
        $where = ["userid"=>$userid,"liveid"=>$liveid];
        if(self::get($where)){
            return $this->where($where)->delete();
        }else{
            return 0;
        }
        

    }
    
    //产生一个唯一且６位数的房间号
    public function generatorLiveRoom()
    {
        while(1){
            $num = "0123456789";
            $randId = "";
            for($i=0;$i<6;$i++){
                $dig = $num[mt_rand(0, strlen($num)-1)];
                $randId.=$dig;
            }
    
            $res = Db::name("liveplay")->field("id")->where("live_roomid",$randId)->find();
            if(!$res['id']){
                return $randId;
            } 
            
            
        }
        
    }
}

?>