<template>
  <div>
    <divider>我发起的活动</divider>
    <panel :list="list" :type="type"></panel>
  </div>

</template>

<script>
  import { Group, Cell, Panel, Divider, XButton, XHeader } from 'vux'

  export default {
    name: 'Home',

    components: {
      Group,
      Cell,
      Panel,
      Divider,
      XButton,
      XHeader
    },

    data() {
      return{
        type: '5',
        list: [ ]
      }
    },

    methods: {

    },

    created(){

    },

    mounted(){
      this.defines.setName('我发起的活动')
      var _this = this
      this.axios.get('http://localhost:3003/index')
                    .then(function(response){
                      console.log(response, 'home success');
                      var data = response.data.data
                      _this.list = new Array([data.length])

                      for(var i = 0; i < data.length; ++i){
                        _this.list.push(
                            {
                              'src': data[i].picture_url,
                              'title': data[i].title,
                              'desc': data[i].description,
                              'url': '/project/detailed/' + data[i].id,
                              'meta': {
                                'source': data[i].latitude_longitude,
                                'date': data[i].location,
                                'other': data[i].time
                              }
                            }
                          )
                      }
                    })
                    .catch(function(error){
                      console.log(error, 'home fail');
                    });
    }
  }

</script>