<template>
  <article class="article" role="article">
    <h3 class="entry-title"><router-link :to="'/article/'+item.id">{{ item.title }}</router-link></h3>
    <div class="entry-meta">
      <span><router-link :to="'/tag/'+item.tag"><i class="icon">&#xec33;</i>&nbsp;&nbsp;<span class="tag-item color">{{ item.tag }}</span></router-link></span>
      <span><i class="icon">&#xe64d;</i>{{ item.time }}</span>
      <span><i class="icon">&#xe665;</i>{{ item.reply }}</span>
      <span><i class="icon">&#xe68d;</i>{{ item.flow }}</span>
    </div>
    <div class="entry-content">{{ item.contents }}</div>
  </article>
</template>

<script>
 export default {
   data (){
     return {
     }
   },
   components: {
   },
   props: {
     item: Object
   }
 }
</script>

<style scoped lang='less'>
.article{
  transition: All .3s ease-in-out;
  padding: 4px;
  text-align: left;
  //border: solid 1px rgba(204, 204, 204, 0.66);
  border-top: solid 1px rgba(204,204,204,0.66);
  border-left: solid 2px #FFF;
  &:first-child {
    border-top: none;
  }
  &:hover{
    border-left: solid 2px #555;
    box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
  }
  .entry-title{
    margin-top: 1.2em;
    margin-bottom: .6em;
    font-family: inherit;
    font-weight: 400;
    line-height: 1.35;
    color: inherit!important;
  }
  .entry-meta{
    line-height: 1.3rem;
    span{
      padding: 1px 2px;
      display: inline-block;
      line-height: 18px;
      font-size: 16px;
    }
  }
  .entry-content{
    font-size: .8rem;
    color: #555;
    padding-left: .5rem;
    overflow: hidden;
    text-overflow: clip;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
}
a{
  color: #333!important;
}
</style>