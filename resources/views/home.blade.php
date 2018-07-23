<!DOCTYPE html><html><head><meta charset=utf-8><meta name=viewport content="width=device-width,initial-scale=1"><title>panda</title><link rel=stylesheet type=text/css href=./static/panda.css><script type=text/javascript>// jquery ==> 原生ajax
      // 1. 没有panda cookie 直接跳转登录页面
      // 2. 拥有panda cookie 验证cookie无效，跳转登录页面
      //
      // var url = location.toString()

      // var beg = url.indexOf('?')
      // var end = url.length
      // alert(url)
      // if(beg != -1){
      //   var kv = url.substring(beg, end).split('=')
      //   var k = kv[0].substring(1, 6)
      //   var v = kv[1]
      //   console.log(v, "cookie value")
      //   document.cookie = 'panda=' + v
      // }

      // var isLogin = verifyToken()

      // if(isLogin == false){
      //   //TODO
      //   //跳转到登录页面
      //   window.location = 'http://10.11.26.2:1234/user/weibo_login'
      // }

      // function verifyToken(){
      //   var cookies = document.cookie.split(";")
      //   for(var i = 0; i < cookies.length; ++i){
      //     var kv = cookies[i].split("=");
      //     if(kv[0] == 'panda'){
      //       alert('get cookie: ' + kv[1]);
      //       $.ajax({
      //         type: 'GET',
      //         async: true,
      //         dataType: 'json',
      //         url: 'http://10.11.26.2:1234/user/check_token?token=' + kv[1],
      //         success: function(data){
      //           // TODO 验证token是否有效

      //           if(data.code == "200"){
      //             return true
      //           }
      //           else{
      //             return false
      //           }
      //         },
      //         error: function(data){
      //           console.log(data, 'error data')
      //           alert("error")
      //           return false
      //         }
      //       });
      //     }
      //   }

      // }</script><link href=/static/css/app.a1956a6f6a36e0f30837f824cc862fc4.css rel=stylesheet></head><body><div id=header></div><div id=app></div><div id=footer></div><script type=text/javascript src=/static/js/manifest.2ae2e69a05c33dfc65f8.js></script><script type=text/javascript src=/static/js/vendor.9f15136b0f9c85fd5298.js></script><script type=text/javascript src=/static/js/app.3265008aa3fd8a77279b.js></script></body></html>