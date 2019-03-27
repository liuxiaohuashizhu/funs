<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\TestService;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller {

    private  $test_service;
    protected $redis;
    public function __construct(TestService $test_service){
        $this->test_service = $test_service;
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
        echo "here test";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	    echo "77dsf77";

//        $data = [
//            'user_name' => '呆小草',
//            'user_pwd' => '123456',
//        ];
//        $ret = $this->test_service->insertLocal($data);
//        dd($ret);
	}

	public function test(){
        dd("1222");
        $ret = $this->test_service->getInfoById(2);
        $data = [
            'user_name' => '呆小草',
            'user_pwd' => '123456',
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $ret = $this->test_service->insertLocal($data);
        if($ret){
            dd("create success");
        }
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

    /**
     * 测试redis连接
     */
    public function redistest(){
//        $this->redis->set('test','你是猪');
//        dd(333);
        print_r("444");
        $test = $this->redis->get('test');
        dd($test);
    }

}
