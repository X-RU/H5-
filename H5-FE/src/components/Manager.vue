<template>
  <div>
    <divider style="margin-top: 1em">活动计划</divider>
    <group label-width="4.5em" label-margin-right="2em" label-align="right">
      <x-input title="主题" v-model="subject"></x-input>
      <datetime title="时间" v-model="datetime" format="YYYY-MM-DD HH:mm" :minute-list="['00', '15', '30', '45']" value-text-align="left"></datetime>

      <!-- :show.sync="showAddress" -->
      <x-address title="地址" :list="addressData" :placeholder="addressCode"   v-model="oadc" value-text-align="left"></x-address>

      <x-input title="地点" v-model="location"></x-input>

    </group>


    <group>
      <popup-radio :title="statusMsg"  label-width="4.5em" label-margin-right="2em" label-align="right" :options="options2" v-model="option2" ></popup-radio>
    </group>

    <divider style="margin-top: 1em">主题图片</divider>

    <div id="test">
      <div class="img-container">
        <img :src="mySrc" />
      </div>
      <input id="file" type="file" @change="getFile" ref="file"/>
      <label for="file">画像变更</label>
    </div>
    <x-button style= "width: 67%; margin-top:2em; margin-bottom:1em; " type="primary"
      v-on:click.native="change">
      确认修改
    </x-button>
    <router-view></router-view>

  </div>
</template>


<script>
import { GroupTitle, Group, Cell, XInput, Selector, PopupPicker, Datetime, XNumber, ChinaAddressData, XAddress, XTextarea, XSwitch, XButton, Grid, GridItem, Divider,Card, Checklist, ChinaAddressV4Data, Value2nameFilter as value2name, Checker, CheckerItem, PopupRadio } from 'vux'

  export default {
    components: {
      Group,
      Cell,
      XInput,
      Selector,
      PopupPicker,
      XAddress,
      Datetime,
      XNumber,
      XTextarea,
      XSwitch,
      XButton,
      ChinaAddressData,

      Grid,
      GridItem,
      Divider,
      Card,
      Checklist,
      Checker,
      CheckerItem,
      PopupRadio
    },

    mounted(){
      this.defines.setName('我创建的活动')
      var url = document.location.toString(); //获取url中"?"符后的字串
      if(url.lastIndexOf('/') != -1){
        var pid = url.substring(url.lastIndexOf('/')+1, url.length)
        this.activityId = pid
      }
      alert(this.activityId)
      var _this = this
      this.axios.get('http://localhost:3003/manager',{
                      params: {
                        project_id: _this.activityId
                      }
                    })
                    .then(function(response){
                      var form = response.data.data
                      console.log(form, '~!!')
                      // _this.activityId = form.id
                      _this.subject = form.title
                      _this.location = form.location
                      _this.datetime = form.time
                      _this.detail = form.description
                      _this.addressCode = form.latitude_longitude
                      _this.mySrc = form.picture
                      if(form.status != null){
                        _this.status = form.status
                        _this.statusMsg = form.status
                      }
                      else{
                        _this.statusMsg = '点击修改活动状态'
                      }
                    })
                    .catch(function(error){
                      alert("error")
                      console.log(error);
                    });

    },

    data() {
        return {
          activityId: '',
          subject: '',
          location: '',
          datetime: '1999-10-12 16:00',
          detail: '',
          addressCode: [],
          oadc: [],
          address: '',
          addressData: ChinaAddressData,

          status: '',
          toMembers: '/enroll/members',
          toPhotos: '/enroll/photos',
          toManager: '/enroll/manager',
          status: '',
          statusMsg: '',
          // subjectImg: 'http://owj98yrme.bkt.clouddn.com/236435132238682874.webp',
          // imgSource: '',

          mySrc: 'http://owj98yrme.bkt.clouddn.com//lufei/9.jpg',

          option2: '',
          options2: [
            {
              key: 'A',
              value: '尚未开始'
            },
            {
              key: 'B',
              value: '正在进行'
            },
            {
              key: 'C',
              value: '报名结束'
            },
            {
              key: 'D',
              value: '已经取消'
            }
          ],
        }
    },

    methods: {
      getFile(e){
        let _this = this;
        var file = e.target.files[0]
        if(!e || !window.FileReader){
          alert("浏览器不支持上传文件或者图片文件已损坏")
          return
        }
        let reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onloadend = function(){
          _this.mySrc = this.result
        }
      },
      change(){
        this.address = value2name(this.oadc, ChinaAddressV4Data)
        var _this = this
        alert(this.activityId + ", " + this.subject + ", " + this.datetime + ", " + this.location + ", " + this.address + ", " + this.status + ", " + this.mySrc)
        this.axios.post('',{
                      project_id: _this.activityId,
                      picture: _this.mySrc,
                      title: _this.subject,
                      time: _this.datetime,
                      location: _this.location,
                      latitude_longitude: _this.address,
                      status: _this.status
                  }).then(function(response){
                    if(response.data.status == '1'){
                      alert("更新成功，跳转到活动详情页")
                    }
                    else if(response.data.status = '0'){
                      alert("更新异常")
                    }
                    console.log(_this.list, "!!!!!!!!")
                  })
                  .catch(function(error){
                    alert("error")
                    console.log(error);
                  });
      }

    },

    watch: {
      addressCode: function() {
        // alert(value2name(this.addressVal, ChinaAddressV4Data))
        // this.address = value2name(this.addressCode, ChinaAddressV4Data)
      },
      option2: function(){
        if(this.option2 == "A"){
          this.status = '尚未开始'
        }
        else if(this.option2 == "B"){
          this.status = '正在进行'
        }
        else if(this.option2 == "C"){
          this.status = '报名结束'
        }
        else if(this.option2 == "D"){
          this.status = '已经取消'
        }
        this.statusMsg = '点击修改活动状态'
      }
  }

}
</script>

<style scoped>
.grid-center {
  display: block;
  text-align: center;
  color: #666;
}
.weui-grids {
  background-color: #fff;
}

#test {
    label {
      width: 120px;
      display: block;
      border-radius: 2px;
      color: #fff;
      text-align: center;
      margin-top: 10px;
      font-size: 12px;
      background-color: map-get($global-color-base, primary);
    }
  }
#file {
    display: none;
    z-index: 10;
    width: 120px;
    font-size: 0;
    height: 30px;
}

</style>