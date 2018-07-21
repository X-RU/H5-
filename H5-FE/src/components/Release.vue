<template>
  <div>
    <div style="margin-top: 0.1em;">
      <divider>发起活动</divider>
    </div>
    <group label-width="4.5em" label-margin-right="2em" label-align="center">
      <x-input placeholder="为活动取个名（max=10）..." title="主题" v-model="subject" max=10></x-input>

      <datetime placeholder="点击选取时间" title="时间" v-model="datetime" format="YYYY-MM-DD HH:mm" :minute-list="['00', '15', '30', '45']" value-text-align="left"></datetime>
      
      <!-- :show.sync="showAddress" -->
      <x-address title="地址" :list="addressData" placeholder="请选择地址"   v-model="addressCode" value-text-align="left"></x-address>


      <x-input placeholder="活动详细地点" title="地点" v-model="location"></x-input>
      <!-- <datetime placeholder="点击选取日期" title="日期" v-model="date" value-text-align="left"></datetime> -->
    </group>
    <br/>

    <group>
      <x-textarea max=50 placeholder="是否需要对活动进行介绍或说明..." v-model="detail" />
    </group>

    <br/>
  
    <div id="test">
      <div class="img-container">
        <img :src="mySrc" style="margin-bottom: 1em; width: 100%;" />
      </div>
      <input id="file" type="file" @change="getFile" ref="file"/>
      <label for="file">更换主题图片</label>
    </div>

    <x-button plain type="primary" style="border-radius: 3em; width: 67%; margin-top: 2em; margin-bottom: 2em;" v-on:click.native="publish">发布</x-button>

  </div>
</template>

<script>
  import { GroupTitle, Group, Cell, XInput, Selector, PopupPicker, Datetime, XNumber, ChinaAddressData, XAddress, XTextarea, XSwitch, XButton, Grid, GridItem,ChinaAddressV4Data, Value2nameFilter as value2name, Divider } from 'vux'

  export default {
    name: 'Release',
    
    components: {
      Group,
      GroupTitle,
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
      Grid,
      GridItem,
      Divider
    },

    data () {
      return {
        // cookieV: '',
        subject: '',
        location: '',
        datetime: '',
        detail: '',
        addressCode: [],
        address: '',
        addressData: ChinaAddressData,
        mySrc: 'http://owj98yrme.bkt.clouddn.com//nab/6.jpg'
      }
    },

    methods: {
      publish: function(){
        if(this.subject == '' || this.address == '' || this.location == ''){
          alert("主题、地址和地点为必填项")
          return
        }

        alert( this.subject + ", "+ this. address+ ", " + this.location + ", " + this.detail + ", " + this.datetime + this.mySrc +"!")

        var _this = this
        this.axios.get('http://localhost:3003/release', {
            // token: _this.cookieV,
            title: _this.subject,
            time: _this.datetime,
            location: _this.location,
            latitude_longitude: _this.address,
            picture: _this.mySrc,
            description: _this.detail
          }).then(function (response) {
            console.log(response);
            // alert(response.data.activityId)
            window.location="http://localhost:8080/#/project/detailed/" + '123'

          }).catch(function (error) {
            alert(error.code + ": " + error.msg)
            console.log(error);
          });
      },

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
    },

    watch: {
      addressCode: function() {
        // alert(value2name(this.addressVal, ChinaAddressV4Data))
        this.address = value2name(this.addressCode, ChinaAddressV4Data)
      },
    },

    mounted(){
      this.defines.setName('趣玩活动中心')
    }

  }
</script>

<style>
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