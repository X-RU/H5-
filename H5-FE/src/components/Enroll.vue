<template>
  <div>
      <!-- <divider style="margin-top: 1em">活动详情</divider> -->
      <group label-width="4.5em" label-margin-right="2em" label-align="right">
        <cell title="发布人" value-align="left" :value="releaser"></cell>
        <cell title="主题" value-align="left" :value="subject"></cell>
        <cell title="时间" value-align="left" :value="datetime"></cell>
        <cell title="地址" value-align="left" :value="address"></cell>
        <cell title="地点" value-align="left" :value="location"></cell>
      </group>

      <group label-width="6em" label-margin-right="2em" label-align="right">
        <cell title="报名详情" value-align="left" :link="toMembers" is-link></cell>
        <!-- <cell title="相册" value-align="left" :link="toPhotos" is-link></cell> -->
      </group>

      <group>
          <div id="manager" >
            <cell title="管理（仅限发起人 v-if ）" value-align="left" :link="toManager" is-link v-if="isManager"></cell>
          </div>
      </group>

      <x-button plain type="primary" style="border-radius:99px; width: 67%; margin-top: 2em;" v-on:click.native="enroll" v-if="signin">报名</x-button>

      <x-button plain type="warn" style="border-radius:99px; width: 67%; margin-top: 2em; " v-on:click.native="_cancel" v-if="cancel">取消报名</x-button>

  </div>
</template>


<script>
import { Divider, Group, Cell, XButton, XInput } from 'vux'
export default{
  name: 'Enroll',
  components: {
    Divider,
    Group,
    Cell,
    XButton,
    XInput
  },


  data() {
    return {
      CookieV: '',
      activityId: '',

      releaser: 'randomer',
      datetime: 'a',
      subject: 'oo',
      address: 'xxx',
      location: 'cc',

      isManager: false,
      signin: true,
      cancel: false,
      toMembers: '/members',
      toPhotos: '/photos',
      toManager: '/manager',
    }
  },

  methods: {
    enroll(){
      var _this = this
     
      //         /project/attend
      this.axios.get('http://localhost:3003/enroll', {
          activityId: this.activityId
        }).then(function (response) {
          console.log(response);
          _this.signin = !_this.signin
          _this.cancel = !_this.cancel

        }).catch(function (error) {
          alert(error.code + ": " + error.msg)
          console.log(error);
        });
    },

    _cancel(){

      var _this = this
      //         /project/cancel
      this.axios.get('http://localhost:3003/enroll', {
          activityId: this.activityId
        }).then(function (response) {
          console.log(response);
          _this.signin = !_this.signin
          _this.cancel = !_this.cancel

        }).catch(function (error) {
          alert(error.code + ": " + error.msg)
          console.log(error);
        });
    }

  },

  mounted(){
    this.defines.setName('趣玩报名中心')
    //获取   ?pid=123  中的项目编号
    var url = document.location.toString(); //获取url中"?"符后的字串
    if(url.lastIndexOf('/') != -1){
      var pid = url.substring(url.lastIndexOf('/')+1, url.length)
      this.activityId = pid
      // kv = url.split('=')
      // if(kv[0] == 'pid' && kv[1] != null){
      //   this.activityId = kv[1]
      // }
    }
    // alert(this.activityId)

    this.toMembers = '/project/relationPeople/' + this.activityId
    // this.toPhotos = '/photos?pid=' + this.activityId
    this.toManager = '/project/manager/' + this.activityId

    // document.cookie='panda=' + 'this_is_panda_cookie'
    // var cookies = document.cookie.split(';')
    // if(cookies == ''){
    //   return
    // }

    // for(var i = 0; i < cookies.length; ++i){
    //   var kv = cookies[i].split('=')
    //   if(kv[0] == 'panda'){
    //     this.cookieV = kv[1]
    //     this.showManage = true
    //     // alert(this.cookieV)
    //     break
    //   }
    // }
    // if(this.cookieV == ''){
    //   return
    // }

    var _this = this;
    if(this.activityId != ''){
      this.axios.get('http://localhost:3003/project', {
          token: _this.cookieV,
          activityId: _this.activityId
        }).then(function (response) {
          console.log(response);
            _this.releaser = response.data.creator
            _this.subject = response.data.title
            _this.datetime = response.data.time
            _this.address = response.data.latitude_longitude
            _this.location = response.data.location

            if(response.data.isManager == 'true'){
              _this.isManager = true
            }
            else{
              _this.isManager = false
            }

            _this.signin = false
            _this.cancel = true

        }).catch(function (error) {
          alert(error.code + ": " + error.msg)
          console.log(error);
        });
    }
  }
}
</script>

<style scoped>


</style>