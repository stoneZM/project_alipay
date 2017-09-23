<?php
/**
 * Created by PhpStorm.
 * User: stone
 * Date: 2017/9/9
 * Time: 14:57
 */

namespace app\common\model;
use app\user\model\User;
use think\Model;
use think\Validate;

class Base extends Model
{

    protected $resultSetType = 'collection';

    protected $rule = array();
    protected $msg = array();
    protected $listRow = 20;
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $list_rows = 15;


    function __construct($data=[])
    {
        parent::__construct($data);
        self::beforeInsert(function(){

            return $this->validate_data($this->rule,$this->msg);
        });
        self::beforeUpdate(function(){
            return $this->validate_data($this->rule,$this->msg);
        });
       $this->list_rows = config('paginate')['list_rows'];
    }
    public function getList($map=null,$list_name='list'){

        $list =  $this->where($map)->order('id desc')->paginate($this->listRow);
        if($list->total()){
            return array(
                $list_name=>$list,
                'page'=>$list->render()
            );
        }
        return array(
            $list_name=>$list,
            'page'=>''
        );
    }



    /**
     * 删除操作
     * @param $id
     * @return bool
     */
    public function del($id){

        $task = $this->get($id);
        if(!$task){
            $this->error = lang('task_not_exist');
            return false;
        }
        if($task->delete()){
            return true;
        }else{
            $this->error = lang('delete').lang('fail');
            return false;
        }

    }

    /** 数据验证
     * @return array|bool|string
     */
    protected function validate_data($rule,$msg){

        if(!$rule&&!$msg){
            return true;
        }
        $validate = new Validate($rule,$msg);
        if(!$validate->check($this->data)){
            $this->error = $validate->getError();
            return false;
        }else{
            return true;
        }
    }

    static public function update_user_auth_session($new_content){

        if (is_array($new_content)){
            $user_auth = session('user_auth');
            foreach ($new_content as $key=>$value) {
                   if ($key == 'expir_time'){
                       $user_auth['expir_time'] = date('Y年m月d日',$value);
                   }else{
                       $user_auth[$key] = $value;
                   }
            }
            session('user_auth',$user_auth);
            session('user_auth_sign', data_auth_sign($user_auth));
        }
    }



    static public function set_session($where){

        $user = User::get($where);
        if ($user){
            $user = $user->toArray();
        }else{
            return false;
        }
        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'user_name'       => $user['user_name'],
            'last_login_time' => $user['last_login_time'],
            'is_vip' => $user['is_vip'],
            'phone_num'=>$user['phone_num']
        );

        if($user['is_vip'] == 1){
            $vip_info = db('vip_info')->where(array('user_id'=>$user['id']))->find();
            //检查会员是否已到期
            if ($vip_info['expir_time']<time()){
                //取消会员
                $auth['is_vip'] = 0;
                db('user')->where(array('id'=>$user['id']))->update(array('is_vip'=>0));
                db('vip_info')->where(array('user_id'=>$user['id']))->delete();
            }
            $auth['expir_time'] = date('Y年m月d日',$vip_info['expir_time']);
            $auth['begin_time'] = date('Y年m月d日',$vip_info['begin_time']);

        }else{
            $auth['expir_time'] = 0;
            $auth['begin_time'] = 0;
        }
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
    }
}