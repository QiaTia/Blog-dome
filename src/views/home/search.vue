<template>
 <div class="container typo">
  <!-- 文章列表。主题内容区域 -->
    <div class="col"> 
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
      <el-button @click="nextPage">load More Date ! </el-button>
    </div>
 </div>
</template>

<script>
import articles from '@/components/home/article.vue'
import elAside from '@/components/home/aside.vue'
 export default {
   data () {
     return {
      i:'',
      page:1,
      articles: [
        {
          id:'',
          title:'数据加载中, 请稍等...',
          tag:'wait',
          time:'2016-06-06',
          reply:'0',
          flow:'0',
          contents:'数据加载中, 请稍等片刻...'
        },{
          id:'',
          title:'数据加载中, 请稍等...',
          tag:'wait',
          time:'2016-06-06',
          reply:'0',
          flow:'0',
          contents:'数据加载中, 请稍等片刻...'
        },{
          id:'',
          title:'数据加载中, 请稍等...',
          tag:'wait',
          time:'2016-06-06',
          reply:'0',
          flow:'0',
          contents:'数据加载中, 请稍等片刻...'
        },{
          id:'',
          title:'数据加载中, 请稍等...',
          tag:'wait',
          time:'2016-06-06',
          reply:'0',
          flow:'0',
          contents:'数据加载中, 请稍等片刻...'
        }
      ]
     }
   },
   components: {
    articles,
    elAside
   },
   methods: {
    nextPage(){
      this.page++
      this.object_list()
    },
    object_list(){
      this.i = (this.$route.params.i)?this.$route.params.i:''
      this.$ajax.get('?search='+this.i+'&page='+this.page).then((response)=>{
        if(response.data === null){
          this.$message({
            message: '已经没有跟多啦！',
            type: 'warning'
          });
        }
        this.articles = response.data
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

