<template>
 <div class="container typo">
  <div class="article-list mdui-col-md-8">
    <articles
      v-for="(item , index) in articles" 
      :item='item'
      :key="index"></articles>
  </div>
 </div>
</template>

<script>
import articles from '@/components/home/article.vue'
 export default {
   data () {
     return {
      i:'',
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
      ]
     }
   },
   components: {
    articles
   },
   methods: {
    object_list(){
      this.i = (this.$route.params.i)?this.$route.params.i:''
      this.$ajax.get('https://qiatia.cn/api/?search='+this.i).then((response)=>{
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
}
</style>

