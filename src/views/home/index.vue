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
      <div class="apply-list col-md-4"></div>
    </div>
  <!-- page分页 -->
    <div class="footer-wrapper">
      <div class="page-list">
        <router-link class="page-item" v-for="(item, index) in pages" :key="index" :to="'./'+item">{{item}}</router-link>
      </div>
    </div>
 </div>
</template>

<script>
import articles from '@/components/home/article.vue'
import banner from '@/components/home/banner.vue'
 export default {
  data () {
     return {
      articles: [
        {
          id:'1',
          title:'QiaTia test articles',
          tag:'PHP',
          time:'2018-10-25',
          reply:'3',
          flow:'5',
          contents:'QiaTia test articles...'
        }
       ],
      pages: [1,2,3,4,5,6]
     }
  },
  components: {
    articles,
    banner
   },
  methods:{
    // codeing
    object_list(){
      this.i = (this.$route.params.i)?this.$route.params.i:1
      this.$ajax.get('https://qiatia.cn/api/?articles='+this.i).then((response)=>{
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
    this.$ajax.get('https://api.gushi.ci/all.json').then((response)=>{
      this.$notify({
        title: response.data.author,
        message: response.data.content
      })
    }).then((error)=>{
      console.error(error)
    })
  }
 }
</script>

<style scoped lang='less'>
.container{
  min-height: 70vh;
  .article-list{
    border: solid 1px rgba(204,204,204,0.66);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 16px;
  }
  .footer-wrapper{
    .page-list{
      display: block;
      padding-top: 8px;
      padding-bottom: 32px;
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
