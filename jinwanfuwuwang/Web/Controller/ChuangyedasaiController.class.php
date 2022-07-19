<?php
namespace Web\Controller;
use \Think\Controller;
class ChuangyedasaiController extends Controller {

    public function index(){
        layout('Layout/chuangyedasai');
        $this->display("index");
    }

    public function richeng(){
        layout('Layout/chuangyedasai');
        $this->display("richeng");
    }

    public function news(){
        layout('Layout/chuangyedasai');
        $news = array(
            array(
                "title"=>"聚合创新力量，共筑美好金湾！金湾区第八届大学生创业大赛开始报名啦",
                "url"=>"https://mp.weixin.qq.com/s/piu9jrHwnM8_xAkcvg4rFQ",
                "date"=>"2021/06/15"
            ),
            array(
                "title"=>"通知|好消息！6月28、30日金湾区第八届大学生创赛指导进校园啦~来看看大赛启动会怎么说",
                "url"=>"https://mp.weixin.qq.com/s/CSbYyJCnoJMavDw6sn52pg",
                "date"=>"2021/06/18"
            ),
            array(
                "title"=>"第一轮项目征集中~快来参加金湾区第八届大学生创业大赛，还有知名导师进校园为你提供专业指导~",
                "url"=>"https://mp.weixin.qq.com/s/iLt3P6BL6nbYSd67mO0oYg",
                "date"=>"2021/06/22"
            ),
            array(
                "title"=>"纯干货分享！创业大赛导师教你如何撰写完美商业计划书和路演PPT~",
                "url"=>"https://mp.weixin.qq.com/s/b8azeXFlxVkx-osAeSAkjA",
                "date"=>"2021/07/01"
            ),
            array(
                "title"=>"金湾区第八届大学生创业大赛10月开赛，首轮征集57个项目入围",
                "url"=>"https://mp.weixin.qq.com/s/SWyg02J5bUg1Dx4xios5qQ",
                "date"=>"2021/07/20"
            ),
            array(
                "title"=>"金湾创业大赛往届冠军访谈丨冠军团队是怎样炼成的？快来领取成功指南",
                "url"=>"https://mp.weixin.qq.com/s/BP3yG31mUB05iHws6Lv_WQ",
                "date"=>"2021/08/06"
            ),
            array(
                "title"=>"金湾创业大赛往届冠军访谈丨创业大赛如何突出重围，这位前辈这样说......",
                "url"=>"https://mp.weixin.qq.com/s/1z6mtpQN6MYmUyp8rjbmPQ",
                "date"=>"2021/08/26"
            ),
            array(
                "title"=>"金湾创业大赛往届落地项目团队访谈丨嘿~这里有一份获奖秘籍，打开看看吧",
                "url"=>"https://mp.weixin.qq.com/s/idc5iT377xnbF8aVOwqBFg",
                "date"=>"2021/08/26"
            ),
            array(
                "title"=>"第二轮项目征集启动！2W奖金激烈角逐中！文末有参赛攻略大礼包哦~",
                "url"=>"https://mp.weixin.qq.com/s/G-Hepwqg4TqbZ629WidfbA",
                "date"=>"2021/08/31"
            ),
            array(
                "title"=>"创业大赛复赛入围名单出炉~赛前集训营热力开启，助你拿下决赛入场券！",
                "url"=>"https://mp.weixin.qq.com/s/5NSP0pshNapn_RUyE4AACA",
                "date"=>"2021/09/22"
            ),
            array(
                "title"=>"精彩回顾~金湾区第8届大学生创业大赛集训营顺利结束",
                "url"=>"https://mp.weixin.qq.com/s/OzW05hu6IMapDDQ1ciUcng",
                "date"=>"2021/09/28"
            ),
            array(
                "title"=>"决赛，我们来了！金湾区第八届大学生创业大赛决赛入围名单及日程安排出炉",
                "url"=>"https://mp.weixin.qq.com/s/PE-ytMhiX-vPVnK7pLvyOg",
                "date"=>"2021/10/11"
            ),
            array(
                "title"=>"投票啦！金湾区第八届大学生创业大赛最佳网络人气团队评选，快来投上你宝贵的一票！",
                "url"=>"https://mp.weixin.qq.com/s/ahbedgrKjUnWgPiKJh6DhQ",
                "date"=>"2021/10/15"
            ),
            array(
                "title"=>"“最佳网络人气团队奖”投票结果公布！金湾区第八届大学生创业大赛决赛即将上演",
                "url"=>"https://mp.weixin.qq.com/s/uj3THgWlt2iv01tYC1NMhg",
                "date"=>"2021/10/21"
            ),
            array(
                "title"=>"金湾区第八届大学生创业大赛圆满收官 澳科大优秀创业团队首次参赛",
                "url"=>"https://mp.weixin.qq.com/s/5Qe4Cb20pgE7KIuCyfly2A",
                "date"=>"2021/10/25"
            ),
        );
        $this->assign("news",array_reverse($news));
        $this->display("news");
    }

    public function projects(){
        layout('Layout/chuangyedasai');
        $this->display("projects");
    }



    /****============================== */
}