<template>
 <div class="container typo">
  <!-- bannner轮播图区域 组件化调用 -->
    <banner></banner>
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
      <div class="page-list">
        <el-pagination
          layout="prev, pager, next"
          @current-change="handleCurrentChange"
          :total="63"
          :current-page="currentpages"
          :page-size="12">
          </el-pagination>
        <!-- <router-link class="page-item" v-for="(item, index) in pages" :key="index" :to="'/page/'+item">{{item}}</router-link> -->
      </div>
    </div>
 </div>
</template>

<script>
import articles from '@/components/home/article.vue'
import banner from '@/components/home/banner.vue'
import elAside from '@/components/home/aside.vue'
 export default {
  data () {
     return {
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
        },{
          id:'',
          title:'数据加载中, 请稍等...',
          tag:'wait',
          time:'2016-06-06',
          reply:'0',
          flow:'0',
          contents:'数据加载中, 请稍等片刻...'
        }
       ],
      currentpages: 1
     }
  },
  components: {
    articles,
    banner,
    elAside
   },
  methods:{
    // 分页点击
    handleCurrentChange(val) {
      this.$router.push({ path:`/page/${val}`})
      //console.log(`当前页: ${val}`);
    }, 
    // 数据加载
    object_list(){
      this.i = (this.$route.params.i)?this.$route.params.i:1
      this.currentpages = this.i
      this.$ajax.get('?articles='+this.i).then((response)=>{
        this.articles = response.data
        //window.scroll(0, 0)
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
        this.object_list()
      },
      deep: true
    }
  },
  created() {
    this.object_list()
    // 获取古诗词
    this.$ajax.get('https://api.gushi.ci/all.json').then((response)=>{
      this.$notify({
        title: response.data.author,
        message: response.data.content
      })
    }).catch((error)=>{
      console.log(error)
    })
  }
 }
</script>

<style scoped lang='less'>
.container{
  min-height: 70vh;
  .article-list{
    // border: solid 1px rgba(204,204,204,0.66);
    border: 1px solid rgba(0,0,0,.14);
    background-color: #fff;
    box-shadow: 0 3px 8px -6px rgba(0,0,0,.1);
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 16px;
  }
  .footer-wrapper{
    .page-list{
      display: block;
      border: 1px solid rgba(0,0,0,.14);
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 3px 8px -6px rgba(0,0,0,.1);
      margin-top: 8px;
      margin-bottom: 32px;
      text-align: center;
      .page-item{
        display: inline-block;
        padding: 8px 16px;
      }
    }
  }
}
.typo{
  .router-link-active{
    background-size:0% 0px,0px 0%,100% 2px,0px 0%;
  }
}
</style>
