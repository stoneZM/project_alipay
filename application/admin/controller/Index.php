<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Setting as model_setting;
use app\admin\model\PayAccount as model_pay_account;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
	
	/**
     * @Description: 支付设置
     * @Author: 云的缔造者
     * @email: 736383301@qq.com
     * @return  string
     */
    public function paySetting()
    {
        $module    = 'pay';
        $SettingMd = new model_setting();
        $rd   = $SettingMd->get(array('module'=>$module));
        $data = array();
        if($rd){
            $data = string2array($rd['setting']);
        }

        if($this->request->isPost()) {
            $_info = $this->request->post()['info'];

            $info = array();
            $info['module'] = $module;
            $info['setting'] = array2string($_info);
            $time = time();
            if($rd){
                $info['edittime'] = $time;
                $result = $SettingMd->save($info, ['id' => $rd['id']]);
                if($result==0){
                    $this->error('没有修改任何信息');
                }else if($result>0){
                    $this->success('设置成功', 'index/index/paySetting', 1,1);
                }else{
                    $this->error('编辑设置失败');
                }
            }else{
                $info['addtime'] = $time;
                $info['edittime'] = $time;
                $result = $SettingMd->save($info);
                if($result>0){
                    $this->success('设置成功', 'index/index/paySetting', 1,1);
                }else{
                    $this->error($SettingMd->getError());
                }
            }
        }else{
            $this->assign('data', $data);
            return $this->fetch();
        }
    }
	
	//支付记录
	public function recordList()
	{
		$payAccount = new model_pay_account();
        $list = $payAccount->where(array())->order('id DESC')->paginate(15);
        $this->assign('list', $list);
		return $this->fetch();
	}
	
	//删除记录
    public function delete()
    {
        $id = intval(input('id'));
        $payAccount = new model_pay_account();
        $result = $payAccount->destroy(['id' => $id]);
        if($result){
            $this->success('删除成功', 'admin/index/recordList', 1,1);
        }else{
            $this->error($payAccount->getError());
        }
    }
}
