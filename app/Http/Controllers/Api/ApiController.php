<?php namespace App\Http\Controllers\Api;

use App\Common\Error;
use App\Common\Check;
use App\Http\Controllers\Controller;
use App\Services\StarService;
use App\Services\UserService;
use App\Services\TodayHeadlineService;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller {

    protected  $star_service;
    protected  $today_headline_service;
    protected $redis;
    protected $check;
    protected $user_service;
    public function __construct(
        StarService $star_service,
        UserService $user_service,
        Check $check,
        TodayHeadlineService $today_headline_service
    ){
        $this->check = $check;
        $this->star_service = $star_service;
        $this->user_service = $user_service;
        $this->today_headline_service = $today_headline_service;
        $this->redis = Redis::connection();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


    public function test(){
//	    dd(array_intersect([1],[1,2]));
	    dd(array_diff([3,2],[1,2]));

        $condition = array_filter(
            [
                'CBID' => 1,
                'title' => 2,
                'authorid' => 2,
                'authorname' => 7,
            ]
        );
        dd($condition);



        $appKey = 'd81a5f333cf08e225';
        $md5_str = md5(substr($appKey,-4).date("Ymd"));
        $appToken = substr($md5_str,0,12);
        $url = "https://api.xxsy.net/nameCheck/authorNameCheck?appKey=".$appKey."&appToken=".$appToken."&authorname=11";
        dd($url);
    }

	public function getStarInfo(){
        //如果$data_source为空，则获取该用户的所有数据
        $uid = isset($_POST['uid'])?$_POST['uid']:0;
        $pwd = isset($_POST['pwd'])?$_POST['pwd']:'';
        $condition = isset($_POST['condition'])?$_POST['condition']:'';//json数据
        $star_id = isset($_POST['star_id'])?$_POST['star_id']:0;
        $star_id = 1;
        if(!is_numeric($star_id) || $star_id<=0){
            return response(['status' => Error::ERROR_ERROR, 'result' => '参数错误']);
        }
        $star_info = $this->star_service->getInfoById($star_id)->toArray();
        //获取头条数据
        $headline_info = $this->today_headline_service->getDataList(['star_id'=>$star_id]);
        $result = [
            'star_info' => isset($star_info[0])?$star_info[0]:[],
            'data_info'=>$headline_info,
        ];
        return response(['status' => Error::ERROR_NORMAL, 'result' => $result]);
    }


    public function sendMessage(){
        $tel = isset($_POST['tel'])?$_POST['tel']:'';
        $status = Error::ERROR_NORMAL;
        //检查缓存中是否有该验证码
        $code = $this->redis->get($tel);
        if(strlen($code)==6 && is_numeric($code)){
            $result['code'] = $code;
            return response(['status' => $status, 'result' => $result]);
        }
        $judge = $this->check->checkTel($tel);
        if($judge){
            $code = rand(0,1000000);
            $result['code'] = $code;
            $status = Error::ERROR_NORMAL;
            //给用户发注册短信

            //将手机号存储在redis中过期时间为120s;
            $this->redis->setex($tel,120,$code);
        }
        else{
            $result['code'] = '';
            $result['error_code'] = Error::ERROR_TEL_ILLEGAL;
            $result['error_message'] = '手机号非法';
            $status = Error::ERROR_ERROR;
        }
        return response(['status' => $status, 'result' => $result]);
    }



    public function login(){
        $tel = isset($_POST['tel'])?$_POST['tel']:'';
        $code = isset($_POST['code'])?$_POST['code']:'';
        if(empty($tel) || empty($code)){
            $result['error_code'] = Error::ERROR_PARAM_ILLEGAL;
            return response(['status' => Error::ERROR_ERROR, 'result' => $result]);
        }
        $judge = $this->check->checkTel($tel);
        if(!$judge){
            $result['error_code'] = Error::ERROR_TEL_ILLEGAL;
            return response(['status' => Error::ERROR_ERROR, 'result' => $result]);
        }

        $real_code = $this->redis->get($tel);//从redis中取数据作比较
        if(empty($real_code)){//验证码过期
            $result['error_code'] = Error::ERROR_CODE_EXPIRE;
            return response(['status' => Error::ERROR_ERROR, 'result' => $result]);
        }
        if($real_code != $code){//验证码错误
            $result['error_code'] = Error::ERROR_CODE_ILLEGAL;
            return response(['status' => Error::ERROR_ERROR, 'result' => $result]);
        }

        $record = $this->user_service->getDataList(['tel'=>$tel]);
        if(empty($record)){
            $insert['tel'] = $tel;
            $insert['user_name'] = md5('funs'.$tel);
            $this->user_service->insertRecord($insert);
        }
        $record = $this->user_service->getDataList(['tel'=>$tel]);
        if(!empty($record)){
            $record = $record[0];
        }
        return response(['status' => Error::ERROR_NORMAL, 'result' => $record]);
    }
}
