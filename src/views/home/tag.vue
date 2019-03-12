<template>
 <div class="container typo">
   <!-- 文章列表。主题内容区域 -->
    <div class="col"  v-loading.fullscreen.lock="fullscreenLoading"> 
      <div class="article-list col-md-8">
        <articles
          v-for="(item, index) in articles"
          :key="index" 
          :item="item"></articles>
      </div>
      <div class="col-md-4">
        <el-aside></el-aside>
      </div>
    </div>
    <!-- page分页 -->
    <div class="footer-wrapper">
      <el-button @click="nextPage">load Next Page</el-button>
    </div>
 </div>
</template>

<script>
import articles from '@/components/home/article.vue'
import elAside from '@/components/home/aside.vue'
  export default {
   data () {
     return {
      tag: '',
      articles: [],
      page:1,
      fullscreenLoading: true
     }
  },
  components: {
    articles ,
    elAside
  },
  methods: {
    nextPage(){
      this.page++
      this.object_list()
    },
    object_list(){
      this.tag = this.$route.params.i
      this.$ajax.get('?tag='+this.tag+'&page='+this.page).then((response)=>{
        if(response.data === null){
          this.$message({
            message: '已经没有跟多啦！',
            type: 'warning'
          });
        }else{
          this.articles = this.articles.concat(response.data)
        }
        this.fullscreenLoading = false
      }).catch((error)=> {
        console.log(error)
      })
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
        this.object_list()
        this.page = 1
      },
      deep: true
    }
  },
  created() {
    this.object_list()
  }
 }
</script>

<style scoped lang='less'>
.container{
  padding: 16px 0;
  .article-list{
    border: solid 1px rgba(204,204,204,0.66);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 16px;
  }
  .footer-wrapper{
    display: block;
    text-align: center;
    .el-button{
      display: inline-block;
      width: 88%;
      min-width: 220px;
    }
  }
}
</style>
