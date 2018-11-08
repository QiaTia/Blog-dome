<template>
  <div id="reply">
    <div class="reply-wrapper">
      <el-input
        type="textarea"
        :rows="2"
        placeholder="请输入回复内容"
        v-model="replyVal">
      </el-input>
    </div>
    <div class="reply-con-wrapper">
      <ul class="reply-content-list">
        <h3 style="line-height:75px; height:75px;" align="center">还没人来评论哎，快来抢沙发吧</h3>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      i:'',
      replyVal:''
    }
  },
  methods:{
    // codeing
  },
  created() {
    this.i = this.$route.params.i
    // this.$ajax.get('https://qiatia.cn/api/?article='+this.i).then((response)=>{
    //   this.article = response.data
    // }).catch((error)=> {console.log(error)})
  }
 }
</script>
<style scoped lang='less'>
#reply{
  padding: 16px 0;
}
</style>
