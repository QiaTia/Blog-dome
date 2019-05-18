<template>
 <div class="article container" v-loading.fullscreen.lock="fullscreenLoading">
   <header class="article-header">
    <h1>{{ article.title }}</h1>
    <div class="entry-meta" style="margin-top:16px;">
      <span><router-link :to="'/tag/'+article.tag"><i class="icon">&#xec33;</i>&nbsp;&nbsp;<span class="tag-item color">{{ article.tag }}</span></router-link></span>
      <span><i class="icon">&#xe64d;</i>{{ article.time }}</span>
      <a href="#reply"><span><i class="icon">&#xe665;</i>{{ article.reply }}</span></a>
      <span><i class="icon">&#xe68d;</i>{{ article.flow }}</span>
    </div>
   </header>
  <div class="article-entry typo" style="margin:1rem 0;padding: .5rem" v-html="article.con"></div>
  
  <reply></reply>
</div>
</template>
<script>
import reply from '@/components/home/reply.vue'

export default {
  data () {
    return {
       i:'',
       replyVal:'',
       article:[],
       fullscreenLoading: true
     }
  },
  components: {
    reply
  },
  created() {
    this.i = this.$route.params.i
    this.$ajax.get('/?article='+this.i).then((response)=>{
      this.article = response.data
      this.fullscreenLoading = false
    }).catch((error)=> {
      console.log(error)
    })
  }
 }
</script>

<style scoped lang='less'>
.article{
  border: 1px solid rgba(0,0,0,.14);
  background-color: #fff;
  border-radius: 8px;
  margin: 8px auto;
  box-shadow: 0 3px 8px -6px rgba(0,0,0,.1);
  .article-header{
    h1{
      font-size: 18px;
      font-weight: 300;
      display: block;
      margin: 0;
      color: #696969;
      line-height: 35px;
      margin-top: 20px;
      transition: color .3s;
    }
    .entry-meta{
      line-height: 1.3rem;
      span{
        padding: 1px 2px;
        display: inline-block;
        line-height: 18px;
        font-size: 16px;
        i{
          color: #999;
        }
        a{
          color: #434343;
        }
      }
    }
  }
}
</style>