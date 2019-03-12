<template>
 <div class="aside apply-panel">
   <div class="panel-title">
        <a href="javascipt:;" @click="hotArticle">最热点击</a>  /  <a href="javascipt:;" @click="newReply">近期回复</a>
    </div>
    <div class="panel-list">
      <ul class="list typo">
        <template v-if="isAside">
          <li v-for="(item, index) in articles" :key="index"> <router-link :to="'/article/'+item.id">{{ item.title }}</router-link> </li>
        </template>
        <template v-else>
          <li v-for="(item, index) in reply" :key="index">
            {{ item.userName }} > <router-link :to="'/article/'+item.conid+'#reply'" v-html="item.con"></router-link>
          </li>
        </template>
      </ul>
    </div>
 </div>
</template>

<script>
 export default {
   data () {
     return {
       isAside:true,
       reply: [],
       articles: [
        {
          id:'',
          title:'数据加载中, 请稍等...'
        },
        {
          id:'',
          title:'数据加载中, 请稍等...'
        },
        {
          id:'',
          title:'数据加载中, 请稍等...'
        },
        {
          id:'',
          title:'数据加载中, 请稍等...'
        }
       ]
     }
   },
   components: {
     //  
   },
   methods: {
    getData(){
      this.$ajax.get('?hotArticle').then((response)=>{
        this.articles = response.data
        //window.scroll(0, 0)
      }).catch((error)=> {
        console.log(error)
      })
      this.$ajax.get('?newReply').then((response)=>{
        this.reply = response.data
        //window.scroll(0, 0)
      }).catch((error)=> {
        console.log(error)
      })
    },
    hotArticle() {
      this.isAside = true
    },
    newReply() {
      this.isAside = false
    }
   },
   watch: {
    //监听路由，只要路由有变化(路径，参数等变化)都有执行下面的函数，你可以
    $route: {
      handler: function (val, oldVal) {
        //let _urlParams = this.$route.params;
        //created事件触发的函数可以在这里写...  
        //都是componentA组件，声明周期还在，改变不了
        this.articles = []
        this.getData()
      },
      deep: true
    }
  },
  created() {
    this.getData()
  }
 }

</script>

<style scoped lang='less'>
.aside-sticky {
    position: sticky;
    top: 0;
    width: 100%;
}
.apply-panel{
    padding: 0;
    border-radius: 3px;
    border: solid 1px rgba(204, 204, 204, 0.66);
    background-color: #FFF;
  .panel-title{
    // panl标题
    width: 100%;
    padding: .5rem;
    font-size: 1.1rem;
    border-bottom: solid 1px rgba(204, 204, 204, 0.66);;
  }
  .panel-list{
    // panl 内容
    padding: .5rem;
    font-size: 1rem;
    color: #555;
    .list{
      list-style: disc;
      li{
        list-style-type: none;
        padding-left: .5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: clip;
      }
    }
  }
}
</style>