<?php
class VoteAction extends BaseAction
{
    public function _initialize()
    {
        /*
        if(!strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger")) {
        header('Location:http://www.qq.com');
        	EXIT;
        }
        
        if(!strpos($_SERVER['SERVER_NAME'],'m.')&&empty($_POST)){
        	header('Location:'.$_SERVER["HTTP_HOST"]);	
        	exit;
        }
        */
        parent::_initialize();
        $IIIIIllII1ll = 6;
        C('site_url', 'http://' . $_SERVER['HTTP_HOST']);
    }
    protected $user_is_gz = 0;
    public function index()
    {
        $_vid = $_GET['id'];
        $_token = $_GET['token'];
        $IIIII11IIIIl = $_GET['isappinstalled'];
        $IIIIIl1Il1l1 = $_GET['from'];
        if (!isset($IIIIIl1Il1l1) && !isset($IIIII11IIIIl)) {
            if (empty($_COOKIE['wxd_openid'])) {
                if (isset($_GET['wecha_id'])) {
                    $_wxd_openid = $_GET['wecha_id'];
                    setcookie('wxd_openid', $_wxd_openid, time() + 31536000);
                    setcookie('dzp_openid', $_wxd_openid, time() + 31536000);
                    /*
                    setcookie('wxd_openid',$_wxd_openid,time()+31536000,'/','.m.nckyjy.com');
                    setcookie('dzp_openid',$_wxd_openid,time()+31536000,'/','.m.nckyjy.com');
                    */
                    $this->redirect('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
                    die;
                }
            } else {
                if (isset($_GET['wecha_id'])) {
                    if ($_GET['wecha_id'] != $_COOKIE['wxd_openid']) {
                        $_wxd_openid = $_GET['wecha_id'];
                        setcookie('wxd_openid', $_wxd_openid, time() + 31536000);
                        setcookie('dzp_openid', $_wxd_openid, time() + 31536000);
                    }
                    $this->redirect('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
                    die;
                }
            }
        } else {
            $this->redirect('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
            die;
        }
        if ($_vid && empty($_GET['wecha_id'])) {
            $_condition = array('token' => $_token, 'id' => $_vid);
            $_vote_info = M('Vote')->where($_condition)->find();
            if (!$_vote_info) {
                $this->error('没有此活动', U('Home/Index/index'));
            }
            $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
            $_user_info = M('Users')->where(array('id' => $_uid))->find();
            $IIIIIIIlII11['check'] = $_vote_info['check'] + 1;
            M('Vote')->where($_condition)->save($IIIIIIIlII11);
            $IIIIIIl111Il = $_vote_info['check'];
            if (!$IIIIIIl111Il) {
                $IIIIIIl111Il = 0;
            }
            $IIIIIIl111Il = $IIIIIIl111Il + $_vote_info['xncheck'];
            if ($_vote_info['start_time'] < time() && $_vote_info['over_time'] > time()) {
                $IIIII11IIIlI = 1;
            } else {
                $IIIII11IIIlI = 0;
            }
            if ($_COOKIE['wxd_openid']) {
                $_condition5['vid'] = $_vid;
                $_condition5['status'] = array('gt', '0');
                $_condition5['wechat_id'] = $_COOKIE['wxd_openid'];
                $IIIIIlIllIl1 = M('Vote_item')->where($_condition5)->find();
                if ($IIIIIlIllIl1) {
                    $IIIII11IIIll = 1;
                    $IIIII11IIIl1 = $IIIIIlIllIl1['id'];
                }
            }
            $IIIIIllIlII1['vid'] = $_vid;
            $IIIIIllIlII1['status'] = array('gt', '0');
            $IIIII11III1I = array('id' => 'desc');
            $IIIIIIl1lI11 = M('Vote_item')->where("vid={$_vid}")->sum('vcount') + M('Vote_item')->where("vid={$_vid}")->sum('dcount');
            if (empty($IIIIIIl1lI11)) {
                $IIIIIIl1lI11 = 0;
            }
            $IIIIIIl1lI11 = $IIIIIIl1lI11 + $_vote_info['xntps'];
            $IIIII11III1l = M('Vote_item')->where($IIIIIllIlII1)->count();
            if (empty($IIIII11III1l)) {
                $IIIII11III1l = 0;
            }
            $IIIII11III1l = $IIIII11III1l + $_vote_info['xnbms'];
            import('@.ORG.Ppage');
            $IIIIIIIII11I = $_GET['page'];
            $IIIII11III11 = M('Vote_item')->where($IIIIIllIlII1)->select();
            $IIIII11IIlII = count($IIIII11III11);
            $IIIII11IIlIl = $_user_info['myzps'];
            $_sina_ip_look = C('site_url') . '/index.php?g=Wap&m=Vote&a=index&token=' . $_token . '&id=' . $_vid . '&page={page}';
            $IIIII11IIlI1 = new PageClass($IIIII11IIlII, $IIIII11IIlIl, $IIIIIIIII11I, $_sina_ip_look);
            $IIIII11IIllI = $IIIII11IIlI1->page_limit;
            $IIIIIIIII1ll = $IIIII11IIlI1->myde_size;
            $IIIII11IIlll = M('Vote_item')->where($IIIIIllIlII1)->order($IIIII11III1I)->limit($IIIII11IIllI, $IIIIIIIII1ll)->select();
            $IIIII11IIll1 = $IIIII11IIlI1->myde_writewx();
            $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
            if (count($IIIII11IIl1I) > 1) {
                $IIIII11IIl1l = 1;
            } else {
                $IIIII11IIl1l = 0;
            }
            $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
            import('@.ORG.Jssdk');
            $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
            $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
            $this->assign('signPackage', $IIIII1I11ll1);
            $this->assign('ggpic', $IIIII11IIl1I);
            $this->assign('ggduotu', $IIIII11IIl1l);
            $this->assign('page_string', $IIIII11IIll1);
            $this->assign('vote', $_vote_info);
            $this->assign('zuopins', $IIIII11IIlll);
            $this->assign('istime', $IIIII11IIIlI);
            $this->assign('tpl', $IIIIIIl1lI11);
            $this->assign('rc', $IIIII11III1l);
            $this->assign('check', $IIIIIIl111Il);
            $this->assign('ishavezp', $IIIII11IIIll);
            $this->assign('user', $_user_info);
            $this->assign('token', $_token);
            $this->assign('havezpid', $IIIII11IIIl1);
            $this->assign('id', $_vid);
            $this->assign('page', $IIIIIIIII11I);
            $this->display('index$tp1');
        }
    }
    public function rank()
    {
        $_vid = $_GET['id'];
        $_token = $_GET['token'];
        if ($_vid) {
            $_condition = array('token' => $_token, 'id' => $_vid);
            $_vote_info = M('Vote')->where($_condition)->find();
            if (!$_vote_info) {
                $this->error('没有此活动', U('Home/Index/index'));
            }
            $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
            $_user_info = M('Users')->where(array('id' => $_uid))->find();
            $IIIIIIIlII11['check'] = $_vote_info['check'] + 1;
            M('Vote')->where($_condition)->save($IIIIIIIlII11);
            $IIIIIIl111Il = $_vote_info['check'];
            if (!$IIIIIIl111Il) {
                $IIIIIIl111Il = 0;
            }
            $IIIIIIl111Il = $IIIIIIl111Il + $_vote_info['xncheck'];
            if ($_vote_info['statdate'] < time() && $_vote_info['enddate'] > time()) {
                $IIIII11IIIlI = 1;
            } else {
                $IIIII11IIIlI = 0;
            }
            if ($_COOKIE['wxd_openid']) {
                $_condition5['vid'] = $_vid;
                $_condition5['status'] = array('gt', '0');
                $_condition5['wechat_id'] = $_COOKIE['wxd_openid'];
                $IIIIIlIllIl1 = M('Vote_item')->where($_condition5)->find();
                if ($IIIIIlIllIl1) {
                    $IIIII11IIIll = 1;
                    $IIIII11IIIl1 = $IIIIIlIllIl1['id'];
                }
            }
            $IIIIIllIlII1['vid'] = $_vid;
            $IIIIIllIlII1['status'] = 1;
			/*$IIIIIllIlII1['status'] = array('gt', '0');*/
            $IIIII11III1I = array('vcount' => 'desc');
            $IIIIIIl1lI11 = M('Vote_item')->where("vid={$_vid}")->sum('vcount') + M('Vote_item')->where("vid={$_vid}")->sum('dcount');
            if (empty($IIIIIIl1lI11)) {
                $IIIIIIl1lI11 = 0;
            }
            $IIIIIIl1lI11 = $IIIIIIl1lI11 + $_vote_info['xntps'];
            $IIIII11III1l = M('Vote_item')->where($IIIIIllIlII1)->count();
            if (empty($IIIII11III1l)) {
                $IIIII11III1l = 0;
            }
            $IIIII11III1l = $IIIII11III1l + $_vote_info['xnbms'];
            import('@.ORG.Ppage');
            $IIIIIIIII11I = $_GET['page'];
            $IIIII11III11 = M('Vote_item')->where($IIIIIllIlII1)->select();
            $IIIII11IIlII = count($IIIII11III11);
            $IIIII11IIlIl = $_user_info['myzps'];
            $_sina_ip_look = C('site_url') . '/index.php?g=Wap&m=Vote&a=rank&token=' . $_token . '&id=' . $_vid . '&page={page}';
            $IIIII11IIlI1 = new PageClass($IIIII11IIlII, $IIIII11IIlIl, $IIIIIIIII11I, $_sina_ip_look);
            $IIIII11IIllI = $IIIII11IIlI1->page_limit;
            $IIIIIIIII1ll = $IIIII11IIlI1->myde_size;
            $IIIII11IIlll = M('Vote_item')->where($IIIIIllIlII1)->order($IIIII11III1I)->limit($IIIII11IIllI, $IIIIIIIII1ll)->select();
            $IIIII11IIll1 = $IIIII11IIlI1->myde_writewx();
            $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
            if (count($IIIII11IIl1I) > 1) {
                $IIIII11IIl1l = 1;
            } else {
                $IIIII11IIl1l = 0;
            }
            $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
            import('@.ORG.Jssdk');
            $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
            $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
            $this->assign('signPackage', $IIIII1I11ll1);
            $this->assign('ggpic', $IIIII11IIl1I);
            $this->assign('ggduotu', $IIIII11IIl1l);
            $this->assign('page_string', $IIIII11IIll1);
            $this->assign('vote', $_vote_info);
            $this->assign('zuopins', $IIIII11IIlll);
            $this->assign('istime', $IIIII11IIIlI);
            $this->assign('tpl', $IIIIIIl1lI11);
            $this->assign('rc', $IIIII11III1l);
            $this->assign('check', $IIIIIIl111Il);
            $this->assign('ishavezp', $IIIII11IIIll);
            $this->assign('user', $_user_info);
            $this->assign('token', $_token);
            $this->assign('havezpid', $IIIII11IIIl1);
            $this->assign('id', $_vid);
            $this->assign('page', $IIIIIIIII11I);
            $this->display('rank$tp1');
        }
    }
    public function top()
    {
        $_vid = $_GET['id'];
        $_token = $_GET['token'];
        if ($_vid) {
            $_condition = array('token' => $_token, 'id' => $_vid);
            $_vote_info = M('Vote')->where($_condition)->find();
            if (!$_vote_info) {
                $this->error('没有此活动', U('Home/Index/index'));
            }
            $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
            $_user_info = M('Users')->where(array('id' => $_uid))->find();
            $IIIIIIl111Il = $_vote_info['check'];
            if (!$IIIIIIl111Il) {
                $IIIIIIl111Il = 0;
            }
            $IIIIIIl111Il = $IIIIIIl111Il + $_vote_info['xncheck'];
            if ($_vote_info['start_time'] < time() && $_vote_info['over_time'] > time()) {
                $IIIII11IIIlI = 1;
            } else {
                $IIIII11IIIlI = 0;
            }
            if ($_COOKIE['wxd_openid']) {
                $_condition5['vid'] = $_vid;
                $_condition5['status'] = array('gt', '0');
                $_condition5['wechat_id'] = $_COOKIE['wxd_openid'];
                $IIIIIlIllIl1 = M('Vote_item')->where($_condition5)->find();
                if ($IIIIIlIllIl1) {
                    $IIIII11IIIll = 1;
                    $IIIII11IIIl1 = $IIIIIlIllIl1['id'];
                }
            }
            $IIIIIllIlII1['vid'] = $_vid;
            $IIIIIllIlII1['status'] = array('gt', '0');
            $IIIII11III1I = array('vcount' => 'desc');
            $IIIIIIl1lI11 = M('Vote_item')->where("vid={$_vid}")->sum('vcount') + M('Vote_item')->where("vid={$_vid}")->sum('dcount');
            if (empty($IIIIIIl1lI11)) {
                $IIIIIIl1lI11 = 0;
            }
            $IIIIIIl1lI11 = $IIIIIIl1lI11 + $_vote_info['xntps'];
            $IIIII11III1l = M('Vote_item')->where($IIIIIllIlII1)->count();
            if (empty($IIIII11III1l)) {
                $IIIII11III1l = 0;
            }
            $IIIII11III1l = $IIIII11III1l + $_vote_info['xnbms'];
            $IIIII11II1Il = M('Vote_item')->where($IIIIIllIlII1)->order($IIIII11III1I)->limit(0, 300)->select();
            $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
            if (count($IIIII11IIl1I) > 1) {
                $IIIII11IIl1l = 1;
            } else {
                $IIIII11IIl1l = 0;
            }
            $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
            import('@.ORG.Jssdk');
            $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
            $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
            $this->assign('signPackage', $IIIII1I11ll1);
            $this->assign('ggpic', $IIIII11IIl1I);
            $this->assign('ggduotu', $IIIII11IIl1l);
            $this->assign('page_string', $IIIII11IIll1);
            $this->assign('vote', $_vote_info);
            $this->assign('phlist', $IIIII11II1Il);
            $this->assign('istime', $IIIII11IIIlI);
            $this->assign('tpl', $IIIIIIl1lI11);
            $this->assign('rc', $IIIII11III1l);
            $this->assign('check', $IIIIIIl111Il);
            $this->assign('ishavezp', $IIIII11IIIll);
            $this->assign('user', $_user_info);
            $this->assign('token', $_token);
            $this->assign('havezpid', $IIIII11IIIl1);
            $this->assign('id', $_vid);
            $this->display('top$tp1');
        }
    }
    public function ticket()
    {
        if (IS_POST) 
        {
            $arr =$_POST['arr'];
            $result=array_flip($arr);
            $res = array();
            foreach($result as $kk=>$vv)
            {
                if(!empty($vv))
                    $res[] = $vv;

            }
            if(count($res) !==3)
            {
                echo 201;
                die;
            }

            $_zid = $_POST['zid']=$_v;
            $_vid = $_POST['vid'];
            $_token = $_POST['token'];
            if ($_COOKIE['wxd_openid']) 
            {
                $_wxd_openid = $_COOKIE['wxd_openid'];
                $_fusers_info = M('fusers')->where("openid='{$_wxd_openid}'")->find();//当前openid用户是否存在
                if ($_fusers_info && $_fusers_info['is_gz'] == 1) 
                {
                    $_condition = array('token' => $_token, 'id' => $_vid);
                    $_vote_info = M('Vote')->where($_condition)->find();//活动是否存在

                    $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
                    $_user_info = M('Users')->where(array('id' => $_uid))->find();

                    if ($_vote_info['statdate'] > time()) 
                    {
                        $_return['status'] = 103;
                        echo 103;die;
                    } 
                    elseif ($_vote_info['enddate'] < time()) 
                    {
                        $_return['status'] = 104;
                        echo 104;die;
                    } 
                    elseif ($_vote_info['start_time'] < time() && $_vote_info['over_time'] > time() && $_vote_info['btcdxz'] && $_vote_item_info['vcount'] >= $_vote_info['btcdxz']) 
                    {
                        $_return['status'] = 120;
                        echo 120;die;
                    } 
                    else 
                    {
                        //查看今日是否已提交过了
                        $condition7['vid'] = $_vid;
                        $condition7['wecha_id'] = $_wxd_openid;
                        $condition7['touch_time'] = time();
                        $condition7['token'] = $_token;
                        $condition7['touched'] = 1;
                        $start_time = strtotime(date('Y-m-d'));
                        $condition7['touch_time'] = array('gt', $start_time);
                        $_record_count10 = M('vote_record')->where($_condition7)->count();
                        if ($_record_count10) {
                            echo 109;
                            die;
                        } 

                        $_ip = $this->GetIp();
                        $_sina_ip_look = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $_ip;
                        $_sina_data = json_decode($this->api_notice_increment($_sina_ip_look));
                        if ($_user_info['xzlx'] > 0 && !empty($_user_info['area'])) 
                        {
                            if ($_sina_data) 
                            {
                                if ($_user_info['xzlx'] == 1) 
                                {
                                    $_province = $_sina_data->province;
                                } 
                                elseif ($_user_info['xzlx'] == 2) 
                                {
                                    $_province = $_sina_data->city;
                                }
                                if (strpos($_user_info['area'], $_province) === false) 
                                {
                                    $_status1 = 0;
                                } 
                                else 
                                {
                                    $_status1 = 1;
                                }
                            } 
                            else 
                            {
                                $_status1 = 1;
                            }
                        } 
                        else 
                        {
                            $_status1 = 1;
                        }
                        if ($_status1 == 1) 
                        {

                            //开始进行每个选手的插入
                            foreach($arr as $k=>$v)
                            {
                                //选手是否正常
                                $_vote_item_info = M('Vote_item')->where(array('id' => $_zid))->find();//选手
                                if ($_vote_item_info['status'] != 1) 
                                {
                                    $_return['status'] = 107;
                                    echo 107;die;
                                } 

                                //开始插入数据
                                $IIIIIIllII1l['item_id'] = $v;
                                $IIIIIIllII1l['vid'] = $_vid;
                                $IIIIIIllII1l['wecha_id'] = $_wxd_openid;
                                $IIIIIIllII1l['touch_time'] = time();
                                $IIIIIIllII1l['token'] = $_token;
                                $IIIIIIllII1l['touched'] = 1;
                                $IIIIIIllII1l['ip'] = $_ip;
                                $IIIIIIllII1l['area'] = $_sina_data->province . $_sina_data->city;
                                if (M('vote_record')->add($IIIIIIllII1l)) 
                                {
                                    $_return['status'] = 108;
                                    $IIIIIIllII11['vcount'] = $_vote_item_info['vcount'] + 1;
                                    M('vote_item')->where(array('id' => $v))->save($IIIIIIllII11);
                                }

                                if ($_user_info['tpjl']) 
                                {
                                    $IIIIIIllIlII = M('fusers')->where("openid='{$_wxd_openid}'")->getField('jfnum');
                                    M('fusers')->where("openid='{$_wxd_openid}'")->save(array('jfnum' => $IIIIIIllIlII + $_user_info['tpjlnum']));
                                }
                            }

                        } 
                        else 
                        {
                            $_return['status'] = 110;
                            echo 110;die;
                        }
                    }
                } 
                else 
                {
                    $_return['status'] = 102;
                    echo 102;die;
                }
            } 
            else 
            {
                $_return['status'] = 102;
                echo 102;die;
            }

            // echo $_return['status'];
        }
    }
    public function signup()
    {
        if (IS_POST) {
            $_vid = $_POST['id'];
            $_token = $_POST['token'];
            $_condition = array('token' => $_token, 'id' => $_vid);
            $_vote_info = M('Vote')->where($_condition)->find();
            if (!$_vote_info) {
                $this->error('没有此活动', U('Home/Index/index'));
            }
            $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
            $_user_info = M('Users')->where(array('id' => $_uid))->find();
            if ($_vote_info) {
                if ($_vote_info['start_time'] < time() && $_vote_info['over_time'] > time()) {
                    if ($_COOKIE['wxd_openid']) {
                        $_condition5['openid'] = $_COOKIE['wxd_openid'];
                        $_fusers_info = M('fusers')->where($_condition5)->find();
                        if ($_fusers_info) {
                            if ($_fusers_info['is_gz'] == 1) {
                                $IIIII1I11lI1['wechat_id'] = $_COOKIE['wxd_openid'];
                                $IIIII1I11lI1['vid'] = $_vid;
                                $IIIIIlllIllI = M('vote_item')->where($IIIII1I11lI1)->find();
                                if ($IIIIIlllIllI) {
                                    $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $IIIIIlllIllI['id']));
                                } else {
                                    $IIIII11IllII = array();
                                    $IIIII11IllII['vid'] = $_vid;
                                    $IIIII11IllII['wechat_id'] = $_COOKIE['wxd_openid'];
                                    $IIIII11IllII['item'] = strip_tags($_POST['zpname']);
                                    $IIIII11IllII['tourl'] = $_POST['telphone'];
                                    $IIIII11IllII['intro'] = strip_tags($_POST['content']);
                                    $IIIII11IllII['addtime'] = time();
                                    if ($_vote_info['is_sh'] == 0) {
                                        $IIIII11IllII['status'] = 1;
                                    } else {
                                        $IIIII11IllII['status'] = 0;
                                    }
                                    if (!empty($_POST['fileup'])) {
                                        foreach ($_POST['fileup'] as $IIIIIIIlI11I => $IIIIIlI11II1) {
                                            if ($IIIIIIIlI11I == 0) {
                                                $IIIII11IllIl = $this->savepic($IIIIIlI11II1, $_vid);
                                                if ($_user_info['tuchuang']) {
                                                    $IIIII11IllII['startpicurl'] = $this->tcupload($IIIII11IllIl, $_user_info['tuaccesskey'], $_user_info['tusecretkey'], $_user_info['tupicid']);
                                                } else {
                                                    $IIIII11IllII['startpicurl'] = $IIIII11IllIl;
                                                }
                                            }
                                            if ($IIIIIIIlI11I == 1) {
                                                $IIIII11IllI1 = $this->savepic($IIIIIlI11II1, $_vid);
                                                if ($_user_info['tuchuang']) {
                                                    $IIIII11IllII['startpicurl2'] = $this->tcupload($IIIII11IllI1, $_user_info['tuaccesskey'], $_user_info['tusecretkey'], $_user_info['tupicid']);
                                                } else {
                                                    $IIIII11IllII['startpicurl2'] = $IIIII11IllI1;
                                                }
                                            }
                                            if ($IIIIIIIlI11I == 2) {
                                                $IIIII11IlllI = $this->savepic($IIIIIlI11II1, $_vid);
                                                if ($_user_info['tuchuang']) {
                                                    $IIIII11IllII['startpicurl3'] = $this->tcupload($IIIII11IlllI, $_user_info['tuaccesskey'], $_user_info['tusecretkey'], $_user_info['tupicid']);
                                                } else {
                                                    $IIIII11IllII['startpicurl3'] = $IIIII11IlllI;
                                                }
                                            }
                                            if ($IIIIIIIlI11I == 3) {
                                                $IIIII11Illll = $this->savepic($IIIIIlI11II1, $_vid);
                                                if ($_user_info['tuchuang']) {
                                                    $IIIII11IllII['startpicurl4'] = $this->tcupload($IIIII11Illll, $_user_info['tuaccesskey'], $_user_info['tusecretkey'], $_user_info['tupicid']);
                                                } else {
                                                    $IIIII11IllII['startpicurl4'] = $IIIII11Illll;
                                                }
                                            }
                                            if ($IIIIIIIlI11I == 4) {
                                                $IIIII11Illl1 = $this->savepic($IIIIIlI11II1, $_vid);
                                                if ($_user_info['tuchuang']) {
                                                    $IIIII11IllII['startpicurl5'] = $this->tcupload($IIIII11Illl1, $_user_info['tuaccesskey'], $_user_info['tusecretkey'], $_user_info['tupicid']);
                                                } else {
                                                    $IIIII11IllII['startpicurl5'] = $IIIII11Illl1;
                                                }
                                            }
                                        }
                                    }
                                    $IIIII11Ill1I = M('vote_item')->add($IIIII11IllII);
                                    if (!$_fusers_info['telphone']) {
                                        $IIIII11Ill1l = array('telphone' => addslashes($_POST['telphone']));
                                        M('fusers')->where(array('id' => $_fusers_info['id']))->save($IIIII11Ill1l);
                                    }
                                }
                                $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $IIIII11Ill1I));
                            } else {
                                $this->redirect('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
                            }
                        }
                    }
                }
            }
        } else {
            $_vid = $_GET['id'];
            $_token = $_GET['token'];
            if ($_vid) {
                $_condition = array('token' => $_token, 'id' => $_vid);
                $_vote_info = M('Vote')->where($_condition)->find();
                if (!$_vote_info) {
                    $this->error('没有此活动', U('Home/Index/index'));
                }
                $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
                $_user_info = M('Users')->where(array('id' => $_uid))->find();
                if (empty($_user_info['picnum'])) {
                    $IIIII11Il1II = 0;
                    $IIIII11Il1Il = 1;
                } else {
                    $IIIII11Il1II = $_user_info['picnum'] - 1;
                    $IIIII11Il1Il = $_user_info['picnum'];
                }
                $IIIIIIl111Il = $_vote_info['check'];
                if (!$IIIIIIl111Il) {
                    $IIIIIIl111Il = 0;
                }
                $IIIIIIl111Il = $IIIIIIl111Il + $_vote_info['xncheck'];
                if ($_vote_info['start_time'] > time()) {
                    $IIIII11Il1I1 = 1;
                } elseif ($_vote_info['over_time'] < time()) {
                    $IIIII11Il1I1 = 2;
                } else {
                    if ($_COOKIE['wxd_openid']) {
                        $_condition5['openid'] = $_COOKIE['wxd_openid'];
                        $_fusers_info = M('fusers')->where($_condition5)->find();
                        if ($_fusers_info) {
                            if ($_fusers_info['is_gz'] == 1) {
                                $IIIII1I11lI1['wechat_id'] = $_COOKIE['wxd_openid'];
                                $IIIII1I11lI1['vid'] = $_vid;
                                $IIIIIlllIllI = M('vote_item')->where($IIIII1I11lI1)->find();
                                if ($IIIIIlllIllI) {
                                    $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $IIIIIlllIllI['id']));
                                } else {
                                    $IIIII11Il1I1 = 4;
                                }
                            } else {
                                $IIIII11Il1I1 = 3;
                            }
                        } else {
                            $IIIII11Il1I1 = 3;
                        }
                    } else {
                        $IIIII11Il1I1 = 3;
                    }
                }
                $IIIIIllIlII1['vid'] = $_vid;
                $IIIIIllIlII1['status'] = array('gt', '0');
                $IIIII11III1I = array('vcount' => 'desc');
                $IIIIIIl1lI11 = M('Vote_item')->where("vid={$_vid}")->sum('vcount') + M('Vote_item')->where("vid={$_vid}")->sum('dcount');
                if (empty($IIIIIIl1lI11)) {
                    $IIIIIIl1lI11 = 0;
                }
                $IIIIIIl1lI11 = $IIIIIIl1lI11 + $_vote_info['xntps'];
                $IIIII11III1l = M('Vote_item')->where($IIIIIllIlII1)->count();
                if (empty($IIIII11III1l)) {
                    $IIIII11III1l = 0;
                }
                $IIIII11III1l = $IIIII11III1l + $_vote_info['xnbms'];
                $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
                if (count($IIIII11IIl1I) > 1) {
                    $IIIII11IIl1l = 1;
                } else {
                    $IIIII11IIl1l = 0;
                }
                $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
                import('@.ORG.Jssdk');
                $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
                $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
                $this->assign('signPackage', $IIIII1I11ll1);
                $this->assign('ggpic', $IIIII11IIl1I);
                $this->assign('ggduotu', $IIIII11IIl1l);
                $this->assign('page_string', $IIIII11IIll1);
                $this->assign('vote', $_vote_info);
                $this->assign('istime', $IIIII11IIIlI);
                $this->assign('tpl', $IIIIIIl1lI11);
                $this->assign('rc', $IIIII11III1l);
                $this->assign('check', $IIIIIIl111Il);
                $this->assign('ishavezp', $IIIII11IIIll);
                $this->assign('user', $_user_info);
                $this->assign('token', $_token);
                $this->assign('havezpid', $IIIII11IIIl1);
                $this->assign('id', $_vid);
                $this->assign('xzpic', $IIIII11Il1II);
                $this->assign('picnum', $IIIII11Il1Il);
                $this->assign('bmzt', $IIIII11Il1I1);
                $this->display('signup$tp1');
            }
        }
    }
    public function search()
    {
        if (IS_POST) {
            $_vid = $_POST['id'];
            $_token = $_POST['token'];
            if ($_POST['keyword'] != null && is_numeric($_POST['keyword'])) {
                $IIIII1I11Ill = intval(htmlspecialchars($_POST['keyword']));
                $IIIIII1Il1I1 = M('Vote_item')->where(array('id' => $IIIII1I11Ill))->find();
                if ($IIIIII1Il1I1) {
                    $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $IIIII1I11Ill));
                } else {
                    $IIIII1I11lI1 = U('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
                    echo '<script> alert(\'无此ID选手\');location.href=\'' . $IIIII1I11lI1 . '\';</script>';
                }
            } else {
                $IIIII11III1I = array('vcount' => 'desc');
                $IIIII11Il1lI['item'] = array('like', '%' . htmlspecialchars($_POST['keyword']) . '%');
                $IIIII11IIlll = M('Vote_item')->where($IIIII11Il1lI)->order($IIIII11III1I)->select();
                if ($IIIII11IIlll) {
                    $_condition = array('token' => $_token, 'id' => $_vid);
                    $_vote_info = M('Vote')->where($_condition)->find();
                    $_uid = M('token_open')->where(array('token' => $_token))->getField('uid');
                    $_user_info = M('Users')->where(array('id' => $_uid))->find();
                    $IIIIIIl111Il = $_vote_info['check'];
                    if (!$IIIIIIl111Il) {
                        $IIIIIIl111Il = 0;
                    }
                    $IIIIIIl111Il = $IIIIIIl111Il + $_vote_info['xncheck'];
                    if ($_vote_info['start_time'] < time() && $_vote_info['over_time'] > time()) {
                        $IIIII11IIIlI = 1;
                    } else {
                        $IIIII11IIIlI = 0;
                    }
                    if ($_COOKIE['wxd_openid']) {
                        $_condition5['vid'] = $_vid;
                        $_condition5['status'] = array('gt', '0');
                        $_condition5['wechat_id'] = $_COOKIE['wxd_openid'];
                        $IIIIIlIllIl1 = M('Vote_item')->where($_condition5)->find();
                        if ($IIIIIlIllIl1) {
                            $IIIII11IIIll = 1;
                            $IIIII11IIIl1 = $IIIIIlIllIl1['id'];
                        }
                    }
                    $IIIIIllIlII1['vid'] = $_vid;
                    $IIIIIllIlII1['status'] = array('gt', '0');
                    $IIIIIIl1lI11 = M('Vote_item')->where("vid={$_vid}")->sum('vcount') + M('Vote_item')->where("vid={$_vid}")->sum('dcount');
                    if (empty($IIIIIIl1lI11)) {
                        $IIIIIIl1lI11 = 0;
                    }
                    $IIIIIIl1lI11 = $IIIIIIl1lI11 + $_vote_info['xntps'];
                    $IIIII11III1l = M('Vote_item')->where($IIIIIllIlII1)->count();
                    if (empty($IIIII11III1l)) {
                        $IIIII11III1l = 0;
                    }
                    $IIIII11III1l = $IIIII11III1l + $_vote_info['xnbms'];
                    $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
                    if (count($IIIII11IIl1I) > 1) {
                        $IIIII11IIl1l = 1;
                    } else {
                        $IIIII11IIl1l = 0;
                    }
                    $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
                    import('@.ORG.Jssdk');
                    $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
                    $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
                    $this->assign('signPackage', $IIIII1I11ll1);
                    $this->assign('ggpic', $IIIII11IIl1I);
                    $this->assign('ggduotu', $IIIII11IIl1l);
                    $this->assign('page_string', $IIIII11IIll1);
                    $this->assign('vote', $_vote_info);
                    $this->assign('zuopins', $IIIII11IIlll);
                    $this->assign('istime', $IIIII11IIIlI);
                    $this->assign('tpl', $IIIIIIl1lI11);
                    $this->assign('rc', $IIIII11III1l);
                    $this->assign('check', $IIIIIIl111Il);
                    $this->assign('ishavezp', $IIIII11IIIll);
                    $this->assign('user', $_user_info);
                    $this->assign('token', $_token);
                    $this->assign('havezpid', $IIIII11IIIl1);
                    $this->assign('id', $_vid);
                    $this->display('search$tp1');
                } else {
                    $IIIII1I11lI1 = U('Wap/Vote/index', array('id' => $_vid, 'token' => $_token));
                    echo '<script> alert(\'无此选手\');location.href=\'' . $IIIII1I11lI1 . '\';</script>';
                }
            }
        }
    }
    public function add_vote()
    {
        $_token = $this->_post('token');
        $IIIIIlIIIll1 = $this->_post('wecha_id');
        $IIIIIIl1ll11 = $this->_post('tid');
        $IIIII11Il1l1 = rtrim($this->_post('chid'), ',');
        $IIIIIIlI111I = M('Vote_record');
        $IIIII11Il11I = M('vote')->where(array('id' => $IIIIIIl1ll11))->field('votelimit')->find();
        $_condition = array('vid' => $IIIIIIl1ll11, 'wecha_id' => $IIIIIlIIIll1, 'token' => $_token);
        $IIIII1lI1lI1 = $IIIIIIlI111I->where($_condition)->select();
        $IIIII11Il11l = count($IIIII1lI1lI1, COUNT_NORMAL);
        if ($IIIII11Il11l >= (int) $IIIII11Il11I['votelimit'] || $IIIIIlIIIll1 == '') {
            $IIIIIIIlII1l = array('success' => 0);
            echo json_encode($IIIIIIIlII1l);
            die;
        } else {
            $IIIII11Il111 = (int) $IIIII11Il11I['votelimit'] - (int) $IIIII11Il11l - 1;
            $_return = array('item_id' => $IIIII11Il1l1, 'token' => $_token, 'vid' => $IIIIIIl1ll11, 'wecha_id' => $IIIIIlIIIll1, 'touch_time' => time(), 'touched' => 1);
            $IIIIIIIIlI1I = $IIIIIIlI111I->add($_return);
            $IIIIII1IIlIl['id'] = array('in', $IIIII11Il1l1);
            $IIIIIIlI111l = M('Vote_item');
            $IIIIIIlI111l->where($IIIIII1IIlIl)->setInc('vcount');
            $IIIIIIIlII1l = array('success' => 1, 'token' => $_token, 'wecha_id' => $IIIIIlIIIll1, 'tid' => $IIIIIIl1ll11, 'chid' => $IIIII11Il1l1, 'arrpre' => $IIIII11I1III, 'vleft' => $IIIII11Il111);
            echo json_encode($IIIIIIIlII1l);
            die;
        }
    }
    public function detail()
    {
        $_vid = $_GET['id'];
        $_token = $_GET['token'];
        $_zid = $_GET['zid'];
        $IIIII11IIIIl = $_GET['isappinstalled'];
        $IIIIIl1Il1l1 = $_GET['from'];
        //if(!isset($IIIIIl1Il1l1) &&!isset($IIIII11IIIIl)){
        if (empty($_COOKIE['wxd_openid'])) {
            if (isset($_GET['wecha_id'])) {
                $_wxd_openid = $_GET['wecha_id'];
                setcookie('wxd_openid', $_wxd_openid, time() + 31536000);
                //setcookie('wxd_openid',$_wxd_openid,time()+31536000,'/','.m.nckyjy.com');
                $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $_zid));
                die;
            }
        } else {
            if (isset($_GET['wecha_id'])) {
                if ($_GET['wecha_id'] != $_COOKIE['wxd_openid']) {
                    $_wxd_openid = $_GET['wecha_id'];
                    setcookie('wxd_openid', $_wxd_openid, time() + 31536000);
                }
                $this->redirect('Wap/Vote/detail', array('id' => $_vid, 'token' => $_token, 'zid' => $_zid));
                die;
            }
        }
        /*}else{
        
        $this->redirect('Wap/Vote/index',array('id'=>$_vid,'token'=>$_token));
        
        exit;
        
        }*/
        if (empty($_GET['wecha_id'])) {
            $IIIIIllIlIII = M('Vote');
            $_condition = array('token' => $_token, 'id' => $_vid);
            $_vote_info = $IIIIIllIlIII->where($_condition)->find();
            $IIIIIllIlIlI = M('Vote_item');
            $IIIIIllIlII1['id'] = $_zid;
            $_return = $IIIIIllIlIlI->where($IIIIIllIlII1)->find();
            $IIIII1lIl111['vcount'] = array('gt', $_return['vcount']);
            $IIIII1lIl111['vid'] = $_vid;
            $IIIII11I1IIl = $IIIIIllIlIlI->where($IIIII1lIl111)->count();
            $IIIII11I1IIl += 1;
            $IIIIIllIlllI = M('Token_open');
            $IIIIIllIlll1 = $IIIIIllIlllI->where(array('token' => $_token))->getField('uid');
            $_user_info = M('Users')->where(array('id' => $IIIIIllIlll1))->find();
            if ($_COOKIE['wxd_openid']) {
                $_condition5['vid'] = $_vid;
                $_condition5['status'] = array('gt', '0');
                $_condition5['wechat_id'] = $_COOKIE['wxd_openid'];
                $IIIIIlIllIl1 = M('Vote_item')->where($_condition5)->find();
                if ($IIIIIlIllIl1) {
                    $IIIII11IIIll = 1;
                    $IIIII11IIIl1 = $IIIIIlIllIl1['id'];
                }
            }
            $IIIII11IIl1I = M('guanggao')->where('vid=' . $_vid)->order('id desc')->select();
            if (count($IIIII11IIl1I) > 1) {
                $IIIII11IIl1l = 1;
            } else {
                $IIIII11IIl1l = 0;
            }
            $IIIIIII11I1I = M('diymen_set')->where(array('token' => $_token))->find();
            import('@.ORG.Jssdk');
            $IIIII1I11lll = new JSSDK($IIIIIII11I1I['id'], $IIIIIII11I1I['appid'], $IIIIIII11I1I['appsecret']);
            $IIIII1I11ll1 = $IIIII1I11lll->GetSignPackage();
            $this->assign('signPackage', $IIIII1I11ll1);
            $this->assign('ggpic', $IIIII11IIl1I);
            $this->assign('ggduotu', $IIIII11IIl1l);
            $this->assign('zpinfo', $_return);
            $this->assign('vote', $_vote_info);
            $this->assign('mingci', $IIIII11I1IIl);
            $this->assign('ishavezp', $IIIII11IIIll);
            $this->assign('havezpid', $IIIII11IIIl1);
            $this->assign('user', $_user_info);
            $this->assign('token', $_token);
            $this->assign('havezpid', $IIIII11IIIl1);
            $this->assign('id', $_vid);
            $this->display('detail$tp1');
        }
    }
    public function vote()
    {
        $_return['item_id'] = htmlspecialchars($this->_post('id'));
        $_return['vid'] = htmlspecialchars($this->_post('vid'));
        $_return['token'] = htmlspecialchars($this->_post('token'));
        $_return['wecha_id'] = htmlspecialchars($this->_post('wecha_id'));
        $_return['touch_time'] = time();
        $_return['touched'] = 1;
        $IIIIIllIlII1['vid'] = $_return['vid'];
        $IIIIIllIlII1['wecha_id'] = $_return['wecha_id'];
        $IIIII11I1II1 = M('Vote_record');
        if ($IIIII11I1II1->where($IIIIIllIlII1)->find()) {
            $this->ajaxReturn('', '', 1, 'json');
        } else {
            $IIIII11I1II1->add($_return);
            $IIIIII1IIlIl['id'] = array('in', $_return['item_id']);
            $IIIIIIlI111l = M('Vote_item');
            $IIIIIIlI111l->where($IIIIII1IIlIl)->setInc('vcount');
            $this->ajaxReturn('', '', 2, 'json');
        }
    }
    public function add_item()
    {
        $IIIIIIIlI11I = $this->_get('key');
        $IIIIIIIII11I = intval($this->_get('page'));
        $IIIIIIIII1I1 = $this->_get('id');
        $IIIIIllIlII1['vid'] = $IIIIIIIII1I1;
        $IIIIIllIlII1['status'] = 1;
        $IIIIIllII1ll = intval(6);
        $IIIII11I1Ill = $IIIIIIIII11I * $IIIIIllII1ll;
        if ($IIIIIIIlI11I != '' && $IIIIIIIlI11I != NULL) {
            if (is_numeric($IIIIIIIlI11I)) {
                $IIIIIllIlII1['id'] = array('like', '%' . intval(htmlspecialchars($IIIIIIIlI11I)) . '%');
            } else {
                $IIIIIllIlII1['item'] = array('like', '%' . htmlspecialchars($IIIIIIIlI11I) . '%');
            }
        }
        $IIIIIllIlIlI = M('Vote_item')->where($IIIIIllIlII1)->order(array('rank' => 'asc', 'id' => 'desc'))->limit($IIIII11I1Ill, $IIIIIllII1ll)->select();
        $IIIII11I1Il1 = '';
        foreach ($IIIIIllIlIlI as $IIIIIIIllIll => $IIIIIIIlI11l) {
            $IIIII11I1Il1 = $IIIII11I1Il1 . '  

						<li><a href="/index.php?g=Wap&m=Vote&a=show&token=' . $_SESSION['token'] . '&id=' . $IIIIIIIlI11l['id'] . '&wecha_id=' . $_SESSION['wecha_id'] . '&tid=' . $IIIIIIIII1I1 . '"><img src="' . $IIIIIIIlI11l['startpicurl'] . '"></a>

						<p class="info">' . $IIIIIIIlI11l['item'] . '<br>选手编号：<i class="vote_1">' . $IIIIIIIlI11l['id'] . '</i><br>票数：<i class="vote_1">' . $IIIIIIIlI11l['vcount'] . '</i><br></p>

						<p class="vote"><a href="/index.php?g=Wap&m=Vote&a=show&token=' . $_SESSION['token'] . '&id=' . $IIIIIIIlI11l['id'] . '&wecha_id=' . $_SESSION['wecha_id'] . '&tid=' . $IIIIIIIII1I1 . '">详细资料</a></p></li>';
        }
        echo $IIIII11I1Il1;
    }
    public function add_rank()
    {
        $IIIIIIIII11I = intval($this->_get('page'));
        $IIIIIIIII1I1 = $this->_get('id');
        $IIIIIllIlII1['vid'] = $IIIIIIIII1I1;
        $IIIIIllIlII1['status'] = 1;
        $IIIIIllII1ll = intval(6);
        $IIIII11I1Ill = $IIIIIIIII11I * $IIIIIllII1ll;
        $IIIIIllIlIlI = M('Vote_item')->where($IIIIIllIlII1)->order('vcount desc')->limit($IIIII11I1Ill, $IIIIIllII1ll)->select();
        $IIIII11I1Il1 = '';
        foreach ($IIIIIllIlIlI as $IIIIIIIllIll => $IIIIIIIlI11l) {
            $IIIII11I1Il1 = $IIIII11I1Il1 . '  <div class=\'pp\'> 

						<a href="/index.php?g=Wap&m=Vote&a=show&token=' . $_SESSION['token'] . '&id=' . $IIIIIIIlI11l['id'] . '&wecha_id=' . $_SESSION['wecha_id'] . '&tid=' . $IIIIIIIII1I1 . '">

						<img src="' . $IIIIIIIlI11l['startpicurl'] . '">

						

						<div class="tit">' . $IIIIIIIlI11l['id'] . '号 ' . $IIIIIIIlI11l['item'] . '<br />人气：<b>' . $IIIIIIIlI11l['vcount'] . '</b></div>

					</div></a>';
        }
        echo $IIIII11I1Il1;
    }
    private function savepic($IIIII11I1I11, $_vid)
    {
        $IIIIIIlIll11 = date('Ymd');
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads') || !is_dir($_SERVER['DOCUMENT_ROOT'] . '/uploads')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads');
        }
        $IIIIIIlIl1Il = $_SERVER['DOCUMENT_ROOT'] . '/uploads/vote';
        if (!file_exists($IIIIIIlIl1Il) || !is_dir($IIIIIIlIl1Il)) {
            mkdir($IIIIIIlIl1Il);
        }
        $IIIII11I1lII = $_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/' . $_vid;
        if (!file_exists($IIIII11I1lII) || !is_dir($IIIII11I1lII)) {
            mkdir($IIIII11I1lII);
        }
        $IIIIIIlIl1Il = $_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/' . $_vid . '/' . $IIIIIIlIll11;
        if (!file_exists($IIIIIIlIl1Il) || !is_dir($IIIIIIlIl1Il)) {
            mkdir($IIIIIIlIl1Il);
        }
        $IIIIIIlIl1I1 = date('YmdHis') . '_' . rand(10000, 99999) . '.jpeg';
        $IIIII11I1lIl = '/uploads/vote/' . $_vid . '/' . $IIIIIIlIll11 . '/' . $IIIIIIlIl1I1;
        $IIIIIlI11II1 = $_SERVER['DOCUMENT_ROOT'] . $IIIII11I1lIl;
        $_sina_ip_look = 'http://' . $_SERVER['HTTP_HOST'] . $IIIII11I1lIl;
        $IIIII11I1lI1 = base64_decode($IIIII11I1I11);
        $IIIII11I1llI = file_put_contents($IIIIIlI11II1, $IIIII11I1lI1);
        if ($IIIII11I1llI) {
            return $_sina_ip_look;
        }
    }
    private function tcupload($IIIIIlI11II1, $IIIII11I1ll1, $IIIII11I1l1I, $IIIII11I1l1l)
    {
        import('@.ORG.TieTuKu');
        $IIIII11I1l11 = new TTKClient($IIIII11I1ll1, $IIIII11I1l1I);
        $IIIIIII11l11 = $IIIII11I1l11->uploadFile($IIIII11I1l1l, $IIIIIlI11II1);
        $IIIIIII11l11 = str_replace('{', '', $IIIIIII11l11);
        $IIIIIII11l11 = str_replace('}', '', $IIIIIII11l11);
        $IIIIIII11l11 = str_replace('"', '', $IIIIIII11l11);
        $IIIIII1l1l11 = explode(',', $IIIIIII11l11);
        $IIIII11I11II = str_replace('s_url:', '', $IIIIII1l1l11[7]);
        if ($IIIII11I11II) {
            return stripslashes($IIIII11I11II);
        } else {
            return NULL;
        }
    }
    private function GetIP()
    {
        $_ip = false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $_ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IIIII11I11I1 = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if (count($IIIII11I11I1) < 2) {
                $IIIII11I11I1 = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            }
            if ($_ip) {
                array_unshift($IIIII11I11I1, $_ip);
                $_ip = FALSE;
            }
            for ($IIIIIIIllI11 = 0; $IIIIIIIllI11 < count($IIIII11I11I1); $IIIIIIIllI11++) {
                if (!eregi('^(10|172\\.16|192\\.168)\\.', $IIIII11I11I1[$IIIIIIIllI11])) {
                    $_ip = $IIIII11I11I1[$IIIIIIIllI11];
                    break;
                }
            }
        }
        return $_ip ? $_ip : $_SERVER['REMOTE_ADDR'];
    }
    public function hongbao()
    {
        $user_id = '';
        $vcount = 0;
        $vote_id = isset($_GET['id']) ? trim($_GET['id']) : '';
        $token_id = isset($_GET['token']) ? trim($_GET['token']) : '';
        if ($this->user_is_gz == 1) {
            $my_items = M('vote_item')->where(array('wechat_id' => trim($_COOKIE['wxd_openid'])))->getField('vcount')