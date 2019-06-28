<template>
  <div style="margin-top: 0.5em">
    <img class="previewer-demo-img" v-for="(item, index) in list" :src="item.src" width="100" @click="show(index)">
    <div v-transfer-dom>
      <previewer :list="list" ref="previewer" :options="options" @on-index-change="logIndexChange"></previewer>
    </div>

    <divider style="margin-top: 1em; margin-bottom: 1em;" v-if="isUpload">更改我的上传</divider>

    <divider style="margin-top: 1em; margin-bottom: 1em" v-if="_isUpload">上传活动照片</divider>

    <div id="test" v-model="shit">
      <div class="img-container">
        <img :src="mySrc" />
      </div>
      <input id="file" type="file" ref="file" v-on:change="getFile"/>
      <label for="file">选取照片</label>
    </div>
  </div>


</template>

<script>
import { Previewer, TransferDom, Divider, XButton } from 'vux'

export default {
  name: 'Photos',

  directives: {
    TransferDom
  },
  components: {
    Previewer,
    Divider,
    XButton
  },

  mounted(){
    this.defines.setName('活动相关照片')
    var url = document.location.toString(); //获取url中"?"符后的字串
    if(url.indexOf('?') != -1){
      url = url.substring(url.indexOf('?')+1, url.length)
      kv = url.split('=')
      if(kv[0] == 'pid' && kv[1] != null){
        this.activityId = kv[1]
      }
    }

    var _this = this

    this.axios.get('http://localhost:3003/photos',{
                    params: {
                      token: _this.cookieV,
                      project_id: _this.activityId
                    }
                  })
                  .then(function(response){
                    var photos = response.data.photos
                    if(response.data.isLogin == 'true'){
                      _this.isLogin = true
                    }
                    else{
                      _this.isLogin = false
                    }

                    //没有登录肯定没有上传
                    if(response.data.isUpload = 'true'){
                      _this.isUpload = true
                      _this._isUpload = !_this.isUpload
                      _this.mySrc = photos[response.data.index]
                    }
                    else{
                      _this.isUpload = false
                      _this._isUpload = !_this.isUpload
                    }

                    _this.list = new Array([photos.length])
                    
                    for(var i = 0; i < photos.length; ++i){
                      _this.list.push({
                        'msrc': photos[i],
                        'src': photos[i]
                      })
                    }
                    console.log(_this.list, "!!!!!!!!")
                  })
                  .catch(function(error){
                    alert("error")
                    console.log(error);
                  });
  },

  methods: {
    logIndexChange (arg) {
      console.log(arg)
    },
    show (index) {
      this.$refs.previewer.show(index)
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
        for(var i = 0; i < _this.list.length; ++i){
          // alert(_this.list[i])
          // if(_this.mySrc == _this.list[i]){
          //   _this.mySrc = this.result
          //   _this.list[i].msrc = this.result
          //   _this.list[i].src = this.result
          //   break
        }
      }
      // axios
    },

  },
  data () {
    return {
      CookieV: '',
      activityId: '',
      isLogin: false,
      isUpload: true,
      _isUpload: false,
      mySrc: '',
      list: [],

      options: {
        getThumbBoundsFn (index) {
          // find thumbnail element
          let thumbnail = document.querySelectorAll('.previewer-demo-img')[index]
          // get window scroll Y
          let pageYScroll = window.pageYOffset || document.documentElement.scrollTop
          // optionally get horizontal scroll
          // get position of element relative to viewport
          let rect = thumbnail.getBoundingClientRect()
          // w = width
          return {x: rect.left, y: rect.top + pageYScroll, w: rect.width}
          // Good guide on how to get element coordinates:
          // http://javascript.info/tutorial/coordinates
        }
      },
    }
  }
}
</script>

<style scoped>
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
