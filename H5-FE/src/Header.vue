<template>
  <div id="header">
    <x-header :left-options="{showBack: false}">
       {{ this.defines.headerName }}
<!--       <a slot="right" href="#" style="text-decoration:none;"></a>
 -->    </x-header>
  </div>
</template>
<script>
  import { XHeader } from 'vux'

  export default {
    name: 'Header',

    components: {
      XHeader
    },

    data() {
      return {
        // cookieV: '',
        // username: '登录',
        subject: '小竹活动中心'
      }
    },

    mounted(){
      this.defines.setName('小猪活动中心')
      // alert(window.document.location.href.toString())
      
      // var cookies = document.cookie.split(';')
      // if(cookies == ''){
      //   return
      // }
      // for(var i = 0; i < cookies.length; ++i){
      //   var kv = cookies[i].split('=')
      //   if(kv[0] == 'panda'){
      //     this.cookieV = kv[1]
      //     // alert(this.cookieV)
      //     break
      //   }
      // }

      // if(this.cookieV == ''){
      //   return
      // }
      // if contains panda cookie, then get userdata from php
      // var _this = this
      // _this.axios.post('http://api.komavideo.com/news/list',{
      //                 params: {
      //                   token: _this.cookieV,
      //                 }
      //               })
      //               .then(function(response){
      //                 console.log(response, 'success');
      //                 console.log(response.data[0].title, '~~ ~~~~~~~~~~')
      //                 _this.username = response.data[0].title
      //               })
      //               .catch(function(error){
      //                 console.log(error, 'error');
      //               });
      
    }
}

</script>

<style>
/*#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 0;
/*}*/

</style>
