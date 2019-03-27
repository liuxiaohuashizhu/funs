<?php
/**
 *
 * @package   gmat
 * @filename  BaseRespository.php
 * @license   http://www.kaomanfen.com/ kaomanfen license
 * @datetime  16/9/23 下午6:23
 */
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    protected $query;
    protected $model;


    /**
     * 返回 当前 model
     * @author zzy
     * @return mixed
     */
    public function m(){
        return $this->model;
    }
    /**
     * 根据主键id获取数据
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function getById($id, $columns = ['*'])
    {
        $ret = $this->model->find($id, $columns);
        if($ret){
            return $ret->toArray();
        }
        return false;
    }

    /**
     * 支持单个key 的查询
     * @param array/string $where
     * @param array $column
     * @param array $sort  排序
     *       $sort = array('section asc', 'seq asc', 'id asc')
     *               array('section') 不写则默认升序
     * @return mixed
     */
    public function findAll($where, $column = ['*'], $sort = [])
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        $ret = $this->query->get($column);
        if($ret){
            return $ret->toArray();
        }
        return false;
    }

    /**
     * 支持单个key 的查询
     * @param array/string $where
     * @param array $column
     * @param array $sort  排序
     *       $sort = array('section asc', 'seq asc', 'id asc')
     *               array('section') 不写则默认升序
     * @return mixed
     */
    public function findAllByObject($where, $column = ['*'], $sort = [])
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        $ret = $this->query->get($column);
        return $ret;
    }

    /**
     * 根据条件获取单条数据
     * @param array/string $where 条件
     * @param array $sort 排序
     *       array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @param array $column 要查询的字段
     * @return mixed
     */
    public function findOne($where, $column = ['*'], $sort = [])
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        $ret = $this->query->first($column);
        if($ret){
            return $ret->toArray();
        }
        return false;
    }

    /**
     * 根据条件获取单条数据
     * @param array/string $where 条件
     * @param array $sort 排序
     *       array('section asc', 'seq asc', 'id asc')
     *       array('section') / 'section' 不写则默认升序
     * @param array $column 要查询的字段
     * @return mixed
     */
    public function findOneByObject($where, $column = ['*'], $sort = [])
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        return $this->query->first($column);
    }

    /**
     * 根据条件获取总数量
     * @param array/string $where 条件
     * @return int  如 :    |  100
     */
    public function getCount($where)
    {
        $this->query = $this->model;
        $this->where($where);
        $ret = $this->query->count('id');
        return $ret;
    }

    /**
     * 根据条件获取总和
     * @param array/string $where
     * @param string $field
     * @return int 总和的值
     */
    public function getSum($where, $field = '')
    {
        $this->query = $this->model;
        $this->where($where);
        $ret = $this->query->sum($field);
        return $ret;
    }

    /**
     * 获取前limit条数据
     * @param array/string $where 条件
     * @param array $column 字段
     * @param array $sort 排序
     *        array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @param int $limit 条数
     * @return bool
     */
    public function findAllBylimit($where, $column = ['*'], $sort = [], $limit = 10)
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        $ret = $this->query->limit($limit)->get($column);
        if($ret){
            return $ret->toArray();
        }
        return false;
    }

    /**
     * 查找一定条件下当前表的list数据，适用于所有
     * @param array/string $where 条件
     *       $where = array(
     *        'question_id' => $qid,
     *        'status' => array('<>', 1),  //  <>
     *        'parent_id' => array('in', $parentIds), // in
     *        'c_id' => array('in', $Ids), // in
     *        );
     * @param array $column 字段
     *       $column = array('*')
     *       $column = array('id')
     *       $column = array('id', 'age')
     * @param string $group 分组
     *       $group = 'age'
     * @param array $sort 排序
     *       $sort = array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @param int $page 页数 默认第1页
     *       $page = 1
     * @param int $limit 限制条数 默认10条
     *       $limit = 10
     * @param $whereIn  ['id',[1,2,3]]
     * @return bool
     *
     * @example:
     *       $this->getDataList(array('sheet_id' => $sheet_id), array("qid", "section", "seq"), NULL, array('section asc', 'seq asc', 'id asc'), 1, 10);
     */
    public function getDataList($where, $column = ['*'], $group = '', $sort = [], $page = 1, $limit = 10,$with='',$whereIn=[])
    {



        if($with!=''){
            $this->query = $this->model->with($with);
        }
        else{
            $this->query = $this->model;
        }
        //dd($this->model);
        //dd($where);
        if(!empty($whereIn)){
            $this->query = $this->query->whereIn($whereIn[0],$whereIn[1]);
        }
        $this->where($where);
        $this->sort($sort);
        $this->group($group);
        $this->limit($page, $limit);
        $ret = $this->query->get($column);

        if($ret){

            $ret= $ret->toArray();
            //dd($ret);
            return $ret;
        }



        return false;
    }

    /**
     * 自定义sql语句查询
     * @param string $select 查询字段信息
     * @example
     * $lr->select(DB::raw('uid, sum(question_correct) as correct_total, sum(question_incorrect) as incorrect_total'))
     *    ->where('uid', '>', 0)
     *    ->where('time', '>=', $timeStart)
     *    ->where('time', '<', $timeEnd)
     *    ->groupBy('uid')
     *    ->get()->toArray();
     * return $object
     */
    public function selectSql($select = ''){
        $this->query = $this->model;
        $ret = $this->query->select(DB::raw($select));
        return $ret;
    }


    public function execSql(){
        $this->query = $this->model;
        return $this->query;
    }


    /**
     * 分页
     * @param $where
     * @param array $sort 排序
     *        array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @param int $perPage
     * @return mixed
     */
    public function getPageItem($where, $sort = [], $perPage = 200 ,$with='')
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        if($with!=''){
            return $this->query->with($with)->paginate($perPage);
        }
        else{
            return $this->query->paginate($perPage);
        }
//        return $this->query->paginate($perPage);
    }

    /**
     * 分页
     * @param $where
     * @param array $sort 排序
     *        array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @param int $perPage
     * @return mixed
     */
    public function getPageItemArray($where, $sort = [], $perPage = 200)
    {
        $this->query = $this->model;
        $this->where($where);
        $this->sort($sort);
        return $this->query->paginate($perPage)->toArray();
    }
    /**
     * 根据复杂sql自定义查询
     * https://laravel.com/docs/5.2/queries#selects
     * @param $sql eg. 'age > ? and votes = 100'
     * @param array $bindings
     * @param array $column
     * @param array $sort 排序
     *        array('section asc', 'seq asc', 'id asc')
     *       array('section') 不写则默认升序
     * @return mixed
     */
    public function getWhereRaw($sql, $bindings = [], $column = ['*'], $sort = [])
    {
        $this->query = $this->model->whereRaw($sql, $bindings);
        $this->sort($sort);
        return $this->query->get($column);
    }

    /**
     * 插入数据
     * @param array $data
     * @return object model实例化对象  (成功时)
     *          bool false (失败时)
     */
    public function create($data = [])
    {

        if (!empty($data) && is_array($data)) {
            $result = $this->model->create($data);
        }
        return !empty($result) ? $result : false;
    }
    /**
     * 更新数据
     * @param array $where
     * @param array $data
     * @return bool true/false  执行结果
     */
    public function update($where, $data = [])
    {
        if (!empty($where) && !empty($data) && is_array($data)) {
            $this->query = $this->model;
            $this->where($where);
            $result = $this->query->update($data);
        }
        return !empty($result) ? $result : false;
    }

    /**
     * 更新数据 - 自增/自减数据
     * update tablename set num=num+2 where id = $id;
     * @param $where array('id' => $id)
     * @param $field  'num' 字段名
     * @param int $cre  变化幅度 2
     * @return  int   (成功时)
     *           bool  (失败时)
     */
    public function updateBycre($where, $field, $cre = 1){
        if (!empty($where) && $field) {
            $this->query = $this->model;
            $this->where($where);
            $result = $this->query->increment($field, $cre);
        }
        return !empty($result) ? $result : false;
    }
    /**
     * 根据主键id单个或者批量删除数据
     * @param $id mixed string 或者array
     * @return int 删除的行数
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * 通过where条件删除数据
     * @param array $where
     * @return bool true/false 执行结果
     */
    public function delete(array $where)
    {
        if (empty($where)) {
            return 0;
        }
        $this->query = $this->model;
        $this->where($where);
        return $this->query->delete();
    }

    /**
     * 排序
     * @param array $sort
     *        array('section asc', 'seq asc', 'id asc')
     *        array('section') 不写则默认升序
     * @return mixed
     */
    private function sort($sort = [])
    {
        if (!empty($sort) && is_array($sort)) {
            foreach($sort as $key => $val){
                $tmp = explode(' ', trim($val));
                if(!isset($tmp[1])){
                    $tmp[1] = 'asc';
                }
                $this->query = $this->query->orderBy($tmp[0], $tmp[1]);
            }
        }
        return $this->query;
    }

    /**
     * where条件
     * @param array/string $where
     * $where = array(
     *  'question_id' => $qid,
     *  'status' => array('<>', 1),  //  <>
     *  'parent_id' => array('in', $parentIds), // in
     *  'c_id' => array('in', $Ids), // in
     *  );
     * $where = "uid = 1 and time > 10 and time < 20"  // 自定义where条件
     * @return mixed
     */
    private function where($where)
    {
        if(empty($where)){
            return $this->query;
        }
        if (is_array($where)) {
            $whereIn = array();
            $whereOther = array();
            foreach($where as $key => $val){
                if(!empty($val) && is_array($val)){
                    $keyword = $val[0];
                    $value = $val[1];
                    switch($keyword){
                        case 'in':
                        case 'IN':
                            array_pull($where, $key);
                            $whereIn[] = [$key, $value];
                            break;
                        case '<>':
                            array_pull($where, $key);
                            $whereOther[] = [$key, '<>', $value];
                            break;
                        case '>':
                            array_pull($where, $key);
                            $whereOther[] = [$key, '>', $value];
                            break;
                        case '>=':
                            array_pull($where, $key);
                            $whereOther[] = [$key, '>=', $value];
                            break;
                        case '<=':
                            array_pull($where, $key);
                            $whereOther[] = [$key, '<=', $value];
                            break;
                        case '<':
                            array_pull($where, $key);
                            $whereOther[] = [$key, '<', $value];
                            break;
                        default:

                    }
                }
            }
            if($where){
                $this->query = $this->query->where($where);
            }
            if($whereIn){
                foreach($whereIn as $inKey => $inVal){
                    $this->query = $this->query->whereIn($inVal[0], $inVal[1]);
                }
            }
            if($whereOther){
                $this->query = $this->query->where($whereOther);
            }
        }else{
            $this->query = $this->query->whereRaw($where);
        }
        return $this->query;
    }

    /**
     * 分组
     * @param $group
     * @return mixed
     */
    private function group($group){
        if($group){
            $this->query->groupBy($group);
        }
        return $this->query;
    }

    /**
     * 分页获取数据
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    private function limit($page = 1, $limit = 10){
        if($page > 0 && $limit > 0){
            $start = $limit * ($page - 1);
            $this->query->skip($start)->take($limit);
        }
        return $this->query;
    }

    public function increment($map, $field, $num = 1)
    {
        $this->query = $this->model;
        if($num>0){
            $ret = $this->query->where($map)->increment($field, $num);
        }else{
            $ret = $this->query->where($map)->decrement($field, abs($num));
        }

        return $ret;
    }
}